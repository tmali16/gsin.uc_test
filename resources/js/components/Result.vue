<template>
    <b-card class="border-0 PrintBlock">
        <b-row class="">
            <b-col cols="12" class="">
                <b-card class="shadow-sm mb-5 d-print-none">                    
                    <b-row>
                        <b-col cols="2">
                            Выберите язык
                        </b-col>
                        <b-col cols="2">
                            <b-form-select v-model="lang" :options="langs" size="sm" value-field="value" text-field="name"></b-form-select>
                        </b-col>
                        <b-col cols="1">
                            Вывод
                        </b-col>
                        <b-col cols="2">
                            <b-form-select v-model="display" :options="displayVariand" size="sm" value-field="value" text-field="name"></b-form-select>
                        </b-col>
                        <b-col cols="2">
                            <b-button size="sm" variant="info" @click="print" class="text-ligth"> Распечатать</b-button>
                        </b-col>
                    </b-row>
                </b-card>
            </b-col>
            <div id="result" class="row ">
                <b-col cols="12" class="">
                    <b-row>
                        <b-col cols="5" class="text-center">
                            <!-- Кыргыз Республикасынын Өкмөтүнө караштуу <br>Жазаларды аткаруу мамлекеттик кызматы -->
                            <h4>{{settings.filter(x=>x.key == "gsin_name").find(d=>d.lang == "kg").mark}}</h4>
                        </b-col>
                        <b-col cols="2" class="text-center">
                            <b-img center src="/public/img/logo.png" style="height: 100px;" alt="Center image"></b-img>
                        </b-col>
                        <b-col cols="5" class="text-center">
                            <!-- Государственная служба исполнения наказаний при <br>Правительстве Кыргызской Республики -->
                            <h4>{{settings.filter(x=>x.key == "gsin_name").find(d=>d.lang == "ru").mark}}</h4>
                        </b-col>
                    </b-row>
                </b-col>
                <b-col cols="12" >
                    <h2 class="text-center">{{ lang == 'ru' ? 'Результаты тестирования' : 'Сыноонун жыйынтыгы' }}</h2>
                    <b-col cols="12" class="d-flex justify-content-between mt-5 mb-4">
                        <div class="d-flex"><h4>{{ lang == 'ru' ? 'г.Бишкек' : 'Бишкек ш.' }}</h4></div>
                        <div class="d-flex"><h4>{{ lang == 'ru' ? 'УЦ ГСИН при МЮ КР' : 'Өкмөткө караштуу ЖАМКнын ОБ' }}</h4></div>
                    </b-col>
                    <b-list-group class="rounded-0">
                        <b-list-group-item class="d-flex justify-content-between align-items-center rounded-0 border-bottom-1 pl-1 pr-1 border-top-0 border-right-0 border-left-0">
                            <b>{{ lang == 'ru' ? 'ФИО' : 'Аты жону' }}</b>
                            <span variant="transparent" >{{ (candidate != null ? candidate.fn :'') + ' ' + (candidate != null ? candidate.mn :'') +' '+(candidate.ln != null ? candidate.ln :'') }}</span>
                        </b-list-group-item>
                    </b-list-group>
                    <b-list-group class="rounded-0">
                        <b-list-group-item class="d-flex justify-content-between align-items-center rounded-0 border-bottom-1 pl-1 pr-1 border-top-0 border-right-0 border-left-0">
                            <b>{{ lang == 'ru' ? 'Название теста' : 'Сыноо аталышы' }}</b>
                            <span variant="transparent" style="width: 65%; text-align: justify" >{{ lang == 'ru' ? candidate ? candidate.test.title_ru : "": candidate ? candidate.test.title_kg :'' }}</span>
                        </b-list-group-item>
                    </b-list-group>
                    <b-list-group class="rounded-0">
                        <b-list-group-item class="d-flex justify-content-between align-items-center rounded-0 border-bottom-1 pl-1 pr-1 border-top-0 border-right-0 border-left-0">
                            <b>{{ lang == 'ru' ? 'Количество вопросов' : 'Суроолордун саны' }}</b>
                            <span  >{{ candidate ? candidate.test.question_count:'' }}</span  >
                        </b-list-group-item>
                    </b-list-group>
                    <b-list-group class="rounded-0">
                        <b-list-group-item class="d-flex justify-content-between align-items-center rounded-0 border-bottom-1 pl-1 pr-1 border-top-0 border-right-0 border-left-0">
                            <b>{{ lang == 'ru' ? 'Длительность теста' : 'Cыноо мөөнөтү' }}</b>
                            <span variant="transparent" >{{ candidate ? candidate.test.timer + 'мин.' : ' ' }}</span>
                        </b-list-group-item>
                    </b-list-group>
                    <b-list-group class="rounded-0">
                        <b-list-group-item class="d-flex justify-content-between align-items-center rounded-0 border-bottom-1 pl-1 pr-1 border-top-0 border-right-0 border-left-0">
                            <b>{{ lang == 'ru' ? 'Начало теста' : 'Cыноо башталышы' }}</b>
                            <span  >{{ data ? data.test_start : '' | moment("DD.MM.Y HH:mm:ss") }}</span>
                        </b-list-group-item>
                    </b-list-group>
                    <b-list-group class="rounded-0">
                        <b-list-group-item class="d-flex justify-content-between align-items-center rounded-0 border-bottom-1 pl-1 pr-1 border-top-0 border-right-0 border-left-0">
                            <b>{{ lang == 'ru' ? 'Конец теста' : 'Cыноонун аягы' }}</b>
                            <span variant="transparent" >{{ data ? data.test_end : ''| moment("DD.MM.Y HH:mm:ss") }}</span>
                        </b-list-group-item>
                    </b-list-group>
                    <b-list-group class="rounded-0">
                        <b-list-group-item class="d-flex justify-content-between align-items-center rounded-0 border-bottom-1 pl-1 pr-1 border-top-0 border-right-0 border-left-0">
                            <b>{{ lang == 'ru' ? 'Длительность теста' : 'Cыноонун мөөнөтү' }}</b>
                            <span variant="transparent"  >{{ data ? data.duration : ''}}</span>
                        </b-list-group-item>
                    </b-list-group>                
                </b-col>
                <b-col cols="9" offset-sm="2" class="" v-if="display == 'max'">
                    <div class="col text-center" >
                        <template v-if="candidate.point >= candidate.test.min_correct">
                            <h2 class="text-success TestState">{{ lang == 'ru' ? 'Тест сдал' : "Сынактан өттүү"}}</h2>
                        </template>
                        <template v-else>
                            <h2 class="text-danger TestState">{{lang == 'ru' ? 'Тест не сдал' : "Сынактан өткөн жок"}}</h2>
                        </template>
                    </div>
                    <b-media v-for="item in data.test" :key="item.id" class="mt-3">
                        <template v-slot:aside>
                            <b-img :src="item.correct == 1 ? '/public/img/check.png' : '/public/img/close.png'" width="32" alt="placeholder"></b-img>
                        </template>
                        <h5 class="mt-0"><b>{{item.question}}</b></h5>
                        <i>{{item.user_answer}}</i>
                    </b-media>
                </b-col>
                <b-col cols="12" class="w-100 text-center mt-2" v-else>
                    <template v-if="candidate.point >= candidate.test.min_correct">
                        <h2 class="text-success TestState">{{ lang == 'ru' ? 'Тест сдал' : "Сынактан өттүү"}}</h2>
                    </template>
                    <template v-else>
                        <h2 class="text-danger TestState">{{lang == 'ru' ? 'Тест не сдал' : "Сынактан өткөн жок"}}</h2>
                    </template>
                    <br>
                    <span class="text-secondary h4">{{ candidate.point+' / '+candidate.test.question_count}}</span>
                </b-col>
                <b-col>
                    <b-row>
                        <b-col cols="12">
                            <b><label for="" class="left-right">{{lang == 'ru' ? 'Начальник' : 'Жетекчи'}} </label></b>
                        </b-col>
                         <b-col cols="12" class="d-flex justify-content-between">
                            <label style="width: 200px" class="border-bottom border-dark">
                                {{where('zvan')}}
                            </label>
                            <div style="width: 200px" class=" justify-content-md-end float-right">
                                <label for="" style="width: 200px" class="border-bottom border-dark float-left">
                                    {{where('boss')}}
                                </label>
                            </div>
                         </b-col>
                         <b-col class="d-flex justify-content-between">
                             <div></div>
                             <div class="float-left" style="width: 350px">
                             {{ new Date() | moment("DD.MM.Y")}} - {{lang == 'ru' ? 'г.' : 'ж.'}}
                             </div>
                         </b-col>
                    </b-row>

                </b-col>
            </div>
        </b-row>
    </b-card>
</template>

<script>

    export default {
        props:[
            'data',
            'candidate',
            'settings'
        ],
        data(){
            return{
                lang: 'kg',
                langs: [{value: 'kg', name: 'Кыргызча'},{value: 'ru', name: 'Русский'},],
                display: 'max',
                displayVariand: [{value: 'min', name: 'Минимальный'},{value: 'max', name: 'Полный'},],
                shef: []

            }
        },
        mounted() {
            
        },
        methods:{
            print(){
                this.$htmlToPaper('result');
            },
            where(key){
                var f = this.settings.filter(x=>x.key == key)
                var re = f.find(x => x.lang === this.lang).values
                return re;
            }
        }
    }
</script>
<style>

</style>