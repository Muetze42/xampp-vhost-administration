<input type="text" id="list-search" placeholder="Search" class="form-control mx-auto" aria-label="Search" style="max-width: 20rem">
@push('scripts')
    <script>
        window.addEventListener("load", function(){
            document.getElementById("list-search").addEventListener("keyup", function(){
                let search = this.value.toLowerCase();
                let all = document.querySelectorAll("#list li");
                for (let i of all) {
                    let item = i.innerHTML.toLowerCase();
                    item = item.replace(/<(.|\n)*?>/g, '');
                    if (item.indexOf(search) === -1) {
                        i.classList.add("d-none");
                    } else {
                        i.classList.remove("d-none");
                    }
                }
            });
        });
    </script>
@endpush
