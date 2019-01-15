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
            var search = document.location.search;
            switch ($(this).val()) {
                case 'ACTIVE_FROM-DESC':
                    search = insertParam(search, 'sort_by', 'date');
                    search = insertParam(search, 'sort_order', 'desc');

                    window.location.search = search;
                    break;
                case 'NAME-ASC':
                    search = insertParam(search, 'sort_by', 'name');

                    window.location.search = search;
                    break;
            }
        })

        function insertParam(search, key, value)
        {
            key = encodeURI(key); value = encodeURI(value);
            var kvp = search.split('&');
            var i=kvp.length; var x;
            while(i--)
            {
                x = kvp[i].split('=');

                if (x[0]==key)
                {
                    x[1] = value;
                    kvp[i] = x.join('=');
                    break;
                }
            }
            if(i<0) {
                kvp[kvp.length] = [key,value].join('=');
            }
            return kvp.join('&');
        }
    });
</script>
