<template>    
    <b-row class="h-100">        
        <b-col sm="12" class="" style="">
            <b-tabs content-class="pt-0 pb-2 TabContent" nav-class="TabControll" class="shadow" pills card vertical justified>
                <b-tab v-for="(item, index) in Tests" :key="index"  no-body>
                    <template v-slot:title>
                        <b-icon icon="view-list"></b-icon>
                        &nbsp; {{item.title_ru.substring(0, 20)+(item.title_ru.length > 20 ? "..." : "")}}
                    </template>
                    <test-content :test="sendData(index)" :key="item.question.length"></test-content>
                </b-tab>
                <b-tab title="Добавить тест" title-link-class="" class="" >
                    <b-row class="h-100">
                        <b-col cols="12" class="border-bottom mb-3 border-danger">
                            <label for="" style="font-size: 44px;">Новый тест</label>
                        </b-col>
                        <b-col class="" sm="6">
                            <b-row class="mb-4">
                                <b-col sm="4" class=""><b>Тесттин аталышы*:</b></b-col>
                                <b-col>
                                    <b-form-input type="text" v-model="newTest.title_kg" size="sm" ></b-form-input>
                                </b-col>
                            </b-row>
                            <b-row class="mb-4">
                                <b-col sm="4" class=""><b>Баяндоо*:</b></b-col>
                                <b-col>
                                    <b-form-textarea id="textarea-small" size="sm" placeholder="Баяндоосу" v-model="newTest.description_kg"></b-form-textarea>
                                </b-col>
                            </b-row>
                            <b-row class="mb-4">
                                <b-col sm="4" class=""><b>Состояние:</b>{{newTest.state != true ? '&nbsp;&nbsp;Выключена&nbsp;' : "Включена"}}</b-col>
                                <b-col>
                                    <b-form-checkbox v-model="newTest.state" name="check-button" switch >
                                    {{newTest.state != true ? '&nbsp;&nbsp;Включить&nbsp;' : "Выключить"}}
                                    </b-form-checkbox>
                                </b-col>
                            </b-row>
                            <b-row class="mb-4">
                                <b-col sm="4" class=""><b>Вывод вопросов:</b></b-col>
                                <b-col>
                                    <b-form-checkbox v-model="newTest.question_rand" name="check-button" switch>
                                    {{ newTest.question_rand != true ? 'По порядку' :'&nbsp;&nbsp;Случайно&nbsp;' }}
                                    </b-form-checkbox>
                                </b-col>
                            </b-row>
                        </b-col>
                        <!-- РУС -->
                        <b-col class="" sm="6">
                            <b-row class="mb-4">
                                <b-col sm="5" class=""><b>Название:</b></b-col>
                                <b-col><b-form-input id="" type="text" v-model="newTest.title_ru" size="sm" required></b-form-input></b-col>
                            </b-row>
                            <b-row class="mb-4">
                                <b-col sm="5" class=""><b>Описание:</b></b-col>
                                <b-col>
                                    <b-form-textarea id="textarea-small" size="sm" placeholder="Описание" v-model="newTest.description_ru"></b-form-textarea>
                                </b-col>
                            </b-row>
                            <b-row class="mb-4">                                    
                                <b-col sm="5" class=""><b>Длительность теста (мин.)*:</b></b-col>
                                <b-col><b-form-input id="" type="number" v-model="newTest.timer" size="sm" required ></b-form-input></b-col>                                    
                            </b-row>
                            <b-row class="mb-4">                                    
                                <b-col sm="5" class=""><b>Количество вопросов в тесте*:</b></b-col>
                                <b-col><b-form-input id="" type="number" v-model="newTest.question_count" size="sm" required></b-form-input></b-col>
                            </b-row>
                            <b-row class="mb-4">                                    
                                <b-col sm="5" class=""><b>Мин. правельных ответов*:</b></b-col>
                                <b-col><b-form-input id="" type="number" min="0" :max="newTest.question_count" v-model="newTest.min_correct" size="sm" required></b-form-input></b-col>
                            </b-row>
                        </b-col>
                        <b-col cols="12">
                            <b-button squared class="float-right text-white" variant="info" @click="store(newTest, 0)">Сохранить</b-button>
                        </b-col>
                    </b-row>
                    
                </b-tab>
            </b-tabs>
        </b-col>
    </b-row>
</template>

<script>
    export default {
        data(){
            return{
                Tests: [],
                newTest:{
                    title_ru:'',
                    title_kg:'',
                    description_kg: '',
                    description_ru: '',
                    min_correct: 0,
                    state: false,
                    question_count: 0,
                    timer: 0,
                    question_rand: false,
                }
            }
        },
        mounted() {
            this.getData()
        },
        methods:{
            getData: function () {
                axios.get("/change/test/get/").then(response =>{
                    this.Tests = response.data
                }).catch(error=>{
                    console.log(error.data)
                }) 
            },
            sendData(i){
                return this.Tests[i]
            },
            store: function (item) {                
                axios.post("/store/test/add", item
                ).then(response=>{
                    this.ModalShow = false;
                    this.getData()
                    this.showMsg('info', response.data.msg, 'Сообщение')
                    this.resetData()
                }).catch(error=>{
                    this.showMsg('danger', error, 'Сообщение')
                })
            },
            resetData(){
                this.newTest.title_ru = '';
                this.newTest.title_kg = '';
                this.newTest.description_kg = '';
                this.newTest.description_ru = '';
                this.newTest.state = false;
                this.newTest.question_count = 0;
                this.newTest.timer = 0;
                this.newTest.question_rand = false;
            },
            showMsg(variant='info', text, title='Сообщение'){
                this.$bvToast.toast(text, {
                    title: title,
                    autoHideDelay: 5000,
                    variant: variant,
                    solid: true
                })
            },
        }
    }
</script>
