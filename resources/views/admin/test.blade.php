<div class="container mt-5">
    <div class="row justify-content-center">
        <test-vue></test-vue>
    </div>
</div>
<div class="modal" id="DeleteTestModal" tabindex="-1" role="dialog">
    <div class="modal-dialog rounded-0" role="document">
      <div class="modal-content">
        <form action="/destroy/user/" method="get" id="test-destroy-form">
            @csrf
            <div class="modal-header pt-1 pb-1">
            <h5 class="modal-title text-danger">Сообщение</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <p>Вы действительно хотите удалить запись?</p>
            </div>
            <div class="modal-footer pt-1 pb-1">
                <button type="submit" class="btn btn-sm btn-danger" >Удалить</button>
                <a href="#" class="btn btn-sm btn-secondary" data-dismiss="modal">Отмена</a>
            </div>
        </form>
      </div>
    </div>
  </div>
@section('script')
    <script>
        function DestroyUser(e) {
              const form = document.getElementById("test-destroy-form").setAttribute("action", "/destroy/user/"+e.getAttribute("candi"))
        }
        function test_state() {
           const inp = document.getElementById("test_state").checked;

           if(inp){
            document.getElementById("test_stateform-check-label").textContent = "Отлючить";
           }else{
            document.getElementById("test_stateform-check-label").textContent = "Включить";
           }
        }
        function quest_rand() {
           const inp = document.getElementById("quest_rand").checked;

           if(inp){
            document.getElementById("quest_randform-check-label").textContent = "по порядку";
           }else{
            document.getElementById("quest_randform-check-label").textContent = "Случайные";
           }
        }
    </script>
@endsection