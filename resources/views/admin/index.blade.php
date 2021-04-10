@extends('layouts.app')

@section('nav')
    @include('admin.nav')
@endsection
@section("content")
<b-card no-body class="h-100 d-print-none">
  <b-tabs pills card vertical content  content-class="h-100" class="h-100" active-nav-item-class="e" >
    <b-tab title="Статистика"  class="h-100" active>
      <template v-slot:title>
        <b-icon icon="clipboard-data"></b-icon>
        &nbsp; Статистика
      </template>      
      <dashboard-vue></dashboard-vue>      
    </b-tab>
    @can("candidate.read")
    <b-tab title="Кандидаты">
      <template v-slot:title>
      <b-icon icon="person-lines-fill"></b-icon>
      &nbsp; Кандидаты
      </template>
      <b-card-text><candidate-vue></candidate-vue></b-card-text>
    </b-tab>
    @endcan
    @can("tests.read")
    <b-tab title="Тест " >
      <template v-slot:title>
        <b-icon icon="card-list"></b-icon>
        &nbsp; Тест
      </template>
      {{-- <b-card-text><test-vue></test-vue></b-card-text> --}}
      <span class="mb-3" style="font-size: 32px">Тесты</span>
      <test-list></test-list>
    </b-tab>
    @endcan
    {{-- @can("questions.read")
    <b-tab title="Вопросы ">
      <template v-slot:title>
        <b-icon icon="question-octagon"></b-icon>
        &nbsp; Вопросы
      </template>
      {{-- @include('admin.question')
    </b-tab>
    @endcan --}}
    @can("users.read")
    <b-tab title="Пользователи " >
      <template v-slot:title>
        <b-icon icon="person-bounding-box"></b-icon>
        &nbsp; Пользователи
      </template>
      <user-vue></user-vue>
    </b-tab>
    @endcan
    @can("settings.read")
      <b-tab title="Настройки " >
        <template v-slot:title>
          <b-icon icon="gear-wide-connected"></b-icon>
          &nbsp; Настройки
        </template>
        <settings-vue></settings-vue>
      </b-tab>
    @endcan
  </b-tabs>
</b-card>
@endsection