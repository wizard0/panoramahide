<?php

namespace App\Http\Controllers\Admin;

trait ShowPageTrait
{
    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $this->getModel($id)->prepareEditData();

        return view('admin.content.show', [
            'data' => $this->formData,
            'slug' => $this->getSlug(),
            'id' => $id,
            self::LOCALE_VAR => $this->locale
        ]);
    }
}
