<?php

namespace App\Http\Controllers\Voyager;

use TCG\Voyager\Http\Controllers\VoyagerBaseController as BaseVoyagerBaseController;

class VoyagerBaseController extends BaseVoyagerBaseController
{
    public function insertUpdateData($request, $slug, $rows, $data)
    {
        $multi_select = [];

        /*
         * Prepare Translations and Transform data
         */
        $translations = is_bread_translatable($data)
            ? $data->prepareTranslationsWithImages($request, $slug, $rows)
            : [];

        $locale2save = $request->input('locale2save');

        foreach ($rows as $row) {
            // if the field for this row is absent from the request, continue
            // checkboxes will be absent when unchecked, thus they are the exception
            if (!$request->hasFile($row->field) && !$request->has($row->field) && $row->type !== 'checkbox') {
                // if the field is a belongsToMany relationship, don't remove it
                // if no content is provided, that means the relationships need to be removed
                if ((isset($row->details->type) && $row->details->type !== 'belongsToMany') || $row->field !== 'user_belongsto_role_relationship') {
                    continue;
                }
            }

            if (!(($row->field == 'image' || $row->field == 'preview_image') && $locale2save != config('voyager.multilingual.default')))
                $content = $this->getContentBasedOnType($request, $slug, $row, $row->details);
            else {
                $content =  $data->{$row->field};
            }

            if ($row->type == 'relationship' && $row->details->type != 'belongsToMany') {
                $row->field = @$row->details->column;
            }

            /*
             * merge ex_images and upload images
             */
            if ($row->type == 'multiple_images' && !is_null($content)) {
                if (isset($data->{$row->field})) {
                    $ex_files = json_decode($data->{$row->field}, true);
                    if (!is_null($ex_files)) {
                        $content = json_encode(array_merge($ex_files, json_decode($content)));
                    }
                }
            }

            if (is_null($content)) {
                // If the image upload is null and it has a current image keep the current image
                if ($row->type == 'image' && is_null($request->input($row->field)) && isset($data->{$row->field})) {
                    $content = $data->{$row->field};
                }

                // If the multiple_images upload is null and it has a current image keep the current image
                if ($row->type == 'multiple_images' && is_null($request->input($row->field)) && isset($data->{$row->field})) {
                    $content = $data->{$row->field};
                }

                // If the file upload is null and it has a current file keep the current file
                if ($row->type == 'file') {
                    $content = $data->{$row->field};
                }

                if ($row->type == 'password') {
                    $content = $data->{$row->field};
                }
            }

            if ($row->type == 'relationship' && $row->details->type == 'belongsToMany') {
                // Only if select_multiple is working with a relationship
                $multi_select[] = ['model' => $row->details->model, 'content' => $content, 'table' => $row->details->pivot_table];
            } else {
                $data->{$row->field} = $content;
            }
        }

        $data->save();

        // Save translations
        if (count($translations) > 0) {
            $data->saveTranslations($translations);
        }

        foreach ($multi_select as $sync_data) {
            $data->belongsToMany($sync_data['model'], $sync_data['table'])->sync($sync_data['content']);
        }

        return $data;
    }

//    // POST BR(E)AD
//    public function update(Request $request, $id)
//    {
//        $slug = $this->getSlug($request);
//
//        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
//
//        // Compatibility with Model binding.
//        $id = $id instanceof Model ? $id->{$id->getKeyName()} : $id;
//
//        $data = call_user_func([$dataType->model_name, 'findOrFail'], $id);
//
//        // Check permission
//        $this->authorize('edit', $data);
//
//        // Validate fields with ajax
//        $val = $this->validateBread($request->all(), $dataType->editRows, $dataType->name, $id);
//
//        if ($val->fails()) {
//            return response()->json(['errors' => $val->messages()]);
//        }
//
//        if (!$request->ajax()) {
//            $this->insertUpdateData($request, $slug, $dataType->editRows, $data);
//
//            event(new BreadDataUpdated($dataType, $data));
//
//            return redirect()
//                ->route("voyager.{$dataType->slug}.index")
//                ->with([
//                    'message'    => __('voyager::generic.successfully_updated')." {$dataType->display_name_singular}",
//                    'alert-type' => 'success',
//                ]);
//        }
//    }
}

