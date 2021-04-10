<template>
    <b-tabs content-class="bg-transparent h-100 TabContent" nav-class="TabControll" pills="">
        <b-tab active>
            <template v-slot:title>
                <b-icon icon="question-octagon"></b-icon> Вопросы
            </template>
            <questions-list :tests="test" :key="test.question.length"></questions-list>
        </b-tab>
        <b-tab class="p-3" no-body>
            <template v-slot:title>
                <b-icon icon="info-circle"></b-icon>&nbsp;Информация о тесте
            </template>
            <b-row class="pr-3 pl-3" @dblclick="edit=!edit">
                <b-col cols="12" class="border-bottom mb-3 border-danger">
                    <label for="" style="font-size: 44px;" v-if="edit">Настройки теста</label>
                    <label for="" style="font-size: 44px;" v-else>Информация о тесте</label>
                </b-col>
                <b-col class="border border-info p-3" sm="6">
                    <b-row class="mb-1">
                        <b-col sm="3" class=""><b>Тесттин аталышы*:</b></b-col>
                        <b-col>
                            <b-form-input id="" type="text" v-model="Test.title_kg" size="sm" v-if="edit"></b-form-input>
                            <label for="" v-else>{{Test.title_kg}}</label>
                        </b-col>
                    </b-row>
                    <b-row class="mb-1">
                        <b-col sm="3" class=""><b>Баяндоо*:</b></b-col>
                        <b-col>
                            <b-form-textarea id="textarea-small" size="sm" placeholder="Баяндоосу" v-model="Test.description_kg" v-if="edit"></b-form-textarea>
                            <p v-else>{{Test.description_kg}}</p>
                        </b-col>
                    </b-row>
                    <b-row class="mb-1">
                        <b-col sm="3" class=""><b>Состояние:</b><span v-if="edit">{{Test.state != true ? '&nbsp;&nbsp;Выключена&nbsp;' : "Включена"}}</span></b-col>
                        <b-col>
                            <b-form-checkbox v-model="Test.state" name="check-button" v-if="edit" >
                            {{Test.state != true ? '&nbsp;&nbsp;Включить&nbsp;' : "Выключить"}}
                            </b-form-checkbox>
                            <span v-else>{{Test.state != true ? 'Выключена&nbsp;' : "Включена"}}</span>
                        </b-col>
                    </b-row>
                    <b-row class="mb-1">
                        <b-col sm="3" class=""><b>Вывод вопросов:</b></b-col>
                        <b-col>
                            <b-form-checkbox v-model="Test.question_rand" name="check-button" v-if="edit">
                            {{ Test.question_rand != true ? 'По порядку' :'&nbsp;&nbsp;Случайно&nbsp;' }}
                            </b-form-checkbox>
                            <span v-else>{{ Test.question_rand != true ? 'По порядку' :'Случайно&nbsp;' }}</span>
                        </b-col>
                    </b-row>
                </b-col>
                <!-- РУС -->
                <b-col class="border border-info p-3" sm="6">
                    <b-row class="mb-1">
                        <b-col sm="3" class=""><b>Название:</b></b-col>
                        <b-col>
                            <b-form-input id="" type="text" v-model="Test.title_ru" size="sm" required v-if="edit"></b-form-input>
                            <label v-else>{{Test.title_ru}}</label>
                        </b-col>
                    </b-row>
                    <b-row class="mb-1">
                        <b-col sm="3" class=""><b>Описание:</b></b-col>
                        <b-col>
                            <b-form-textarea id="textarea-small" size="sm" placeholder="Описание" v-model="Test.description_ru" v-if="edit"></b-form-textarea>
                            <p v-else>{{Test.description_ru}}</p>
                        </b-col>
                    </b-row>
                    <b-row class="mb-1">
                        <b-col sm="4" class=""><b>Длительность теста (мин.)*:</b></b-col>
                        <b-col>
                            <b-form-input id="" type="number" v-model="Test.timer" size="sm" required v-if="edit"></b-form-input>
                            <span v-else>{{Test.timer}}&nbsp; мин.</span>
                        </b-col>                            
                    </b-row>
                    <b-row class="mb-1">
                        <b-col sm="4" class=""><b>Количество вопросов в тесте*:</b></b-col>
                        <b-col><b-form-input id="" type="number" v-model="Test.question_count" size="sm" required v-if="edit"></b-form-input>
                        <span v-else>{{Test.question_count}} &nbsp;вопросов</span>
                        </b-col>
                    </b-row>
                    <b-row class="mb-1">
                        <b-col sm="4" class=""><b>Мин. правельных ответов*:</b></b-col>
                        <b-col><b-form-input id="" type="number" min="0" :max="Test.question_count" v-model="Test.min_correct" size="sm" required v-if="edit"></b-form-input>
                        <span v-else>{{Test.min_correct}}&nbsp;вопросов</span>
                        </b-col>
                    </b-row>
                </b-col>
                <hr>
                <b-col class="mt-5" cols="12">
                    <b-button class="float-right ml-3 text-light" size="sm" squared variant="info" @click="edit = true" v-if="!edit">Изменить</b-button>
                    <b-button class="float-right ml-3" size="sm" squared variant="success" v-else @click="Update()">Сохранить</b-button>
                    <b-button class="float-right ml-3" size="sm" squared variant="danger" @click="ModalShowTrashRow = true" v-if="edit">Удалить</b-button>
                    <b-button class="float-right ml-3 text-light" size="sm" squared variant="info" @click="edit = false" v-if="edit">Отмена</b-button>
                </b-col>
            </b-row>
            <b-modal ref="my-modal" hide-footer title="Удаление" centered v-model="ModalShowTrashRow">
                <div class="d-block text-center">
                    <h3>Вы действительно хотите удалить  {{test != null ? "тест "+Test.title_ru : 'запись'}}?</h3>
                </div>
                <b-button class="mt-3" variant="danger" block @click="DestroyTest()">Удалить</b-button>
                <b-button class="mt-2" variant="outline-secondary" block @click="!ModalShowTrashRow">Отменить</b-button>
            </b-modal>
        </b-tab>
        
    </b-tabs>
</template>

<script>
    export default {
        props:['test'],
        data(){
            return {
                Test: this.test,
                edit: false,
                ModalShowTrashRow: false,
                DeleteData: []
            }
        },
        watch:{
            test(value){
                console.log(1)
                return value
            }
        },
        mounted() {
            
        },
        methods:{
            Update(){
                axios({
                    method: "POST",
                    url: '/update/test',
                    data: this.Test
                }).then(response=>{
                    this.edit = false;
                    this.showMsg('info', response.data.msg, 'Сообщение')
                }).catch(error=>{
                    this.showMsg('warning', error, 'Сообщение')
                })
            },
            DestroyModal(){
                this.ModalShowTrashRow = true
            },
            showMsg(variant='info', text, title='Сообщение'){
                this.$bvToast.toast(text, {
                    title: title,
                    autoHideDelay: 5000,
                    variant: variant,
                    solid: true
                })
            },
            DestroyTest(){
                axios({
                    method: "GET",
                    url: '/delete/test/'+this.Test.id,
                }).then(response=>{
                    this.ModalShowTrashRow = false;
                    this.getData()
                }).catch(error=>{
                    this.showMsg('warning', error, 'Сообщение')
                }) 
            }
        }
    }
</script>
