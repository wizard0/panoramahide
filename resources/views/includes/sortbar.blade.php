<div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
    <select name="sort">
        <option value="ACTIVE_FROM-DESC" {{
            (isset($sort_by) && $sort_by == 'date')
                ? 'selected'
                : ''
             }}>По дате (сначала новые)
        </option>
        <option value="NAME-ASC" {{
            (isset($sort_by) && $sort_by == 'name')
                ? 'selected'
                : ''
             }}>По алфавиту
        </option>
    </select>
</div>

<script>
    $(document).ready(function() {
        $('select[name="sort"]').on('change', function (event) {
            console.log($(this).val());
            switch ($(this).val()) {
                case 'ACTIVE_FROM-DESC':
                    window.location = window.location.pathname + '?sort_by=date&sort_order=desc';
                    break;
                case 'DATE_CREATE-DESC':
                    window.location = window.location.pathname + '?sort_by=created_at&sort_order=desc';
                    break;
                case 'NAME-ASC':
                    window.location = window.location.pathname + '?sort_by=name&sort_order=asc';
                    break;
            }
        })
    });
</script>
