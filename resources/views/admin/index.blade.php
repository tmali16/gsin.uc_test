@extends('layouts.app')

@section('nav')
    @include('admin.nav')
@endsection
@section("content")
<div class="container-fluid">
    <div class="row">
        @include('admin.layouts.sidebar')
        <main class="col-md-10 ml-sm-auto px4 pt-4" style="min-height: 100vh; background-color: #ecf0f5;">            
            <div class="tab-content" id="v-pills-tabContent">
              <div class="tab-pane fade show " id="v-pills-dashboard" role="tabpanel" aria-labelledby="v-pills-dashboard-tab">
                  1
              </div>
              <div class="tab-pane fade show pt-5" id="v-pills-students" role="tabpanel" aria-labelledby="v-pills-students-tab">
                  @include('admin.students')
              </div>
              <div class="tab-pane fade show  pt-5" id="v-pills-orders" role="tabpanel" aria-labelledby="v-pills-orders-tab">
                  @include('admin.test')
              </div>
              <div class="tab-pane fade show active pt-3" id="v-pills-question" role="tabpanel" aria-labelledby="v-pills-question-tab">
                @if (Request::path() === "admin")
                  @include('admin.question')
                @else
                  @include('admin.layouts.add_question')
                @endif                  
              </div>
              <div class="tab-pane fade show" id="v-pills-reports" role="tabpanel" aria-labelledby="v-pills-students-tab">
                  4
              </div>
            </div>
        </main>
    </div>
</div>
@endsection