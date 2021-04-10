<template>
    <b-container>
        <h2>Тесты</h2>
        <b-row>
            <b-col variant="dark" class="">
                <b-card class="shadow-sm">
                    <b-button  class="rounded-0 btns-shadow" v-b-modal.AddNewTests variant="primary">Создать тест</b-button>
                </b-card>
            </b-col>
            <b-col cols="12" class="">
                <b-card class="mt-3 shadow-sm">
                    <b-row class="row justify-content-center">
                        <b-table  :items="contents" :fields="head" responsive="sm" class="w-100" >
                            <template v-slot:cell(state)="row" class="text-center">
                                <b-icon :icon="row.item.state ? 'check-circle' : 'circle'" size="sm" :variant="row.item.state ? 'success' : 'danger'"  style="height: 24px"></b-icon>                            
                            </template>
                            <template v-slot:cell(timer)="row">
                                {{ row.item.timer +' мин.' }}
                            </template>
                            <template v-slot:cell(question_rand)="row">
                                {{ row.item.question_rand == 1 ? 'По порядку' :'Случайно' }}
                            </template>
                            <template v-slot:cell(submit)="row" style="width: 100px;">
                                <b-button  size="sm" v-model="row.item.state" @click="row.toggleDetails" variant='info'><b-icon icon="gear-wide-connected" size="sm" variant="light"></b-icon></b-button >
                                <b-button  size="sm" v-model="row.item.state" @click="tuggleModal(row.item, 1)" variant="danger"><b-icon icon="trash" size="sm"></b-icon></b-button >
                                <b-button  size="sm" v-model="row.item.state" variant="info"><b-icon icon="card-checklist" size="sm" variant="light"></b-icon></b-button >
                            </template>
                            <template v-slot:cell(created_at)="row">
                                {{ row.item ? row.item.created_at : '' | moment("DD.MM.Y HH:mm:ss") }}
                            </template>
                            <template v-slot:row-details="row">                    
                                <b-card>
                                    <h5>Настройки</h5>
                                    <b-row>
                                        <b-col class="text-sm-right" sm="5">
                                            <b-row class="mb-1">
                                                <b-col sm="5" class="text-sm-right"><b>Тесттин аталышы:</b></b-col>
                                                <b-col><b-form-input id="" type="text" v-model="row.item.title_kg" size="sm" ></b-form-input></b-col>
                                            </b-row>
                                            <b-row class="mb-1">
                                                <b-col sm="5" class="text-sm-right"><b>Баяндоо:</b></b-col>
                                                <b-col>
                                                    <b-form-textarea id="textarea-small" size="sm" placeholder="Описание" v-model="row.item.description_kg"></b-form-textarea>
                                                </b-col>
                                            </b-row>
                                            <b-row class="mb-1">
                                                <b-col sm="5" class="text-sm-right"><b>Состояние:</b></b-col>
                                                <b-col>
                                                    <b-form-checkbox v-model="row.item.state" name="check-button" switch >
                                                    {{row.item.state != true ? 'Включить' : "Выключить"}}
                                                    </b-form-checkbox>
                                                </b-col>
                                            </b-row>
                                            <b-row class="mb-1">
                                                <b-col sm="5" class="text-sm-right"><b>Вывод вопросов:</b></b-col>
                                                <b-col>
                                                    <b-form-checkbox v-model="row.item.question_rand" name="check-button" switch>
                                                    {{ row.item.question_rand == 1 ? 'По порядку' :'Случайно' }}
                                                    </b-form-checkbox>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                        <!-- РУС -->
                                        <b-col class="text-sm-left" sm="6">
                                            <b-row class="mb-1">
                                                <b-col sm="5" class="text-sm-right"><b>Название:</b></b-col>
                                                <b-col><b-form-input id="" type="text" v-model="row.item.title_ru" size="sm" ></b-form-input></b-col>
                                            </b-row>
                                            <b-row class="mb-1">
                                                <b-col sm="5" class="text-sm-right"><b>Описание:</b></b-col>
                                                <b-col>
                                                    <b-form-textarea id="textarea-small" size="sm" placeholder="Описание" v-model="row.item.description_ru"></b-form-textarea>
                                                </b-col>
                                            </b-row>
                                            <b-row class="mb-1">                                    
                                                <b-col sm="5" class="text-sm-right"><b>Длительность теста*:</b></b-col>
                                                <b-col><b-form-input id="" type="text" v-model="row.item.timer" size="sm" ></b-form-input></b-col>                                    
                                            </b-row>
                                            <b-row class="mb-1">                                    
                                                <b-col sm="5" class="text-sm-right"><b>Количество вопросов в тесте*:</b></b-col>
                                                <b-col><b-form-input id="" type="text" v-model="row.item.question_count" size="sm" ></b-form-input></b-col>
                                            </b-row>
                                            <b-row class="mb-1">                                    
                                                <b-col sm="5" class="text-sm-right"><b>Мин. правельных ответов*:</b></b-col>
                                                <b-col><b-form-input id="" type="number" min="0" :max="newTest.question_count" v-model="row.item.min_correct" size="sm" required></b-form-input></b-col>
                                            </b-row>
                                        </b-col>
                                    </b-row>
                                    <b-button size="sm" variant="success" class="rounded-0 float-right  ml-2 mt-2" @click="update(row.item)" >Сохранить</b-button>
                                    <b-button size="sm" @click="row.toggleDetails" class="rounded-0 float-right mt-2">Закрыть</b-button>
                                </b-card>
                            </template>
                        </b-table>
                    </b-row>
                </b-card>
            </b-col>
        </b-row>
        <b-modal id="AddNewTests" title="Новый тест" size="xl" class="reounded-0" centered v-model="ModalShow">
                <b-row>
                    <b-col class="text-sm-right" sm="5">
                        <b-row class="mb-1">
                            <b-col sm="5" class="text-sm-right"><b>Тесттин аталышы*:</b></b-col>
                            <b-col><b-form-input id="" type="text" v-model="newTest.title_kg" size="sm" ></b-form-input></b-col>
                        </b-row>
                        <b-row class="mb-1">
                            <b-col sm="5" class="text-sm-right"><b>Баяндоо*:</b></b-col>
                            <b-col>
                                <b-form-textarea id="textarea-small" size="sm" placeholder="Баяндоосу" v-model="newTest.description_kg"></b-form-textarea>
                            </b-col>
                        </b-row>
                        <b-row class="mb-1">
                            <b-col sm="5" class="text-sm-right"><b>Состояние:</b>{{newTest.state != true ? '&nbsp;&nbsp;Выключена&nbsp;' : "Включена"}}</b-col>
                            <b-col>
                                <b-form-checkbox v-model="newTest.state" name="check-button" switch >
                                {{newTest.state != true ? '&nbsp;&nbsp;Включить&nbsp;' : "Выключить"}}
                                </b-form-checkbox>
                            </b-col>
                        </b-row>
                        <b-row class="mb-1">
                            <b-col sm="5" class="text-sm-right"><b>Вывод вопросов:</b></b-col>
                            <b-col>
                                <b-form-checkbox v-model="newTest.question_rand" name="check-button" switch>
                                {{ newTest.question_rand != true ? 'По порядку' :'&nbsp;&nbsp;Случайно&nbsp;' }}
                                </b-form-checkbox>
                            </b-col>
                        </b-row>
                    </b-col>
                    <!-- РУС -->
                    <b-col class="text-sm-left" sm="6">
                        <b-row class="mb-1">
                            <b-col sm="5" class="text-sm-right"><b>Название:</b></b-col>
                            <b-col><b-form-input id="" type="text" v-model="newTest.title_ru" size="sm" required></b-form-input></b-col>
                        </b-row>
                        <b-row class="mb-1">
                            <b-col sm="5" class="text-sm-right"><b>Описание:</b></b-col>
                            <b-col>
                                <b-form-textarea id="textarea-small" size="sm" placeholder="Описание" v-model="newTest.description_ru"></b-form-textarea>
                            </b-col>
                        </b-row>
                        <b-row class="mb-1">                                    
                            <b-col sm="5" class="text-sm-right"><b>Длительность теста (мин.)*:</b></b-col>
                            <b-col><b-form-input id="" type="number" v-model="newTest.timer" size="sm" required ></b-form-input></b-col>                                    
                        </b-row>
                        <b-row class="mb-1">                                    
                            <b-col sm="5" class="text-sm-right"><b>Количество вопросов в тесте*:</b></b-col>
                            <b-col><b-form-input id="" type="number" v-model="newTest.question_count" size="sm" required></b-form-input></b-col>
                        </b-row>
                        <b-row class="mb-1">                                    
                            <b-col sm="5" class="text-sm-right"><b>Мин. правельных ответов*:</b></b-col>
                            <b-col><b-form-input id="" type="number" min="0" :max="newTest.question_count" v-model="newTest.min_correct" size="sm" required></b-form-input></b-col>
                        </b-row>
                    </b-col>
                </b-row>
            <template v-slot:modal-footer>
                <div class="w-100">                    
                    <b-button size="sm" variant="success" class="rounded-0 float-right  ml-2" @click="store(newTest, 0)" >Сохранить</b-button>
                    <b-button variant="secondary" size="sm" class="rounded-0 float-right " @click="ModalShow=false">
                        Close
                    </b-button>
                </div>
            </template>
        </b-modal>
        <b-modal ref="my-modal" hide-footer title="Удаление" centered v-model="ModalShowTrashRow">
            <div class="d-block text-center">
                <h3>Вы действительно хотите удалить  {{trashData != null ? "тест "+trashData.title_ru : 'запись'}}?</h3>
            </div>
            <b-button class="mt-3" variant="danger" block @click="removeItems()">Удалить</b-button>
            <b-button class="mt-2" variant="outline-secondary" block @click="ModalShowTrashRow">Отменить</b-button>
        </b-modal>
    </b-container>
</template>
<script>
    export default {
        data(){
            return {
                ModalShow: false,
                ModalShowTrashRow: false,
                trashData: null,
                ToastText: null,
                ToastTitle: null,
                ToastVariant: 'info',
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
                },
                head: [
                    {label: 'Название теста',key: 'title_ru',sortable: true},
                    {label: 'Описание',key: 'description_ru',sortable: true},
                    {label: 'Состояние',key: 'state',sortable: false},
                    {label: 'Длительность',key:'timer',sortable: false},
                    {label: 'Количество вопросов',key: 'question_count',sortable: false},
                    {label: 'Вопросы',key: 'question_rand',sortable: false},
                    {label: 'Дата создания',key: 'created_at',sortable: false},
                    {lable: "Событие",key:'submit'}
                ],
                contents: []
            }
        },
        mounted() {
            this.getData();
        },
        methods:{
            getData: function () {
                axios.get("/change/test/get/").then(response =>{
                    this.contents = response.data
                }).catch(error=>{
                    console.log(error.data)
                }) 
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
            update(item){
                axios({
                    method: "POST",
                    url: '/test/update',
                    data: item
                }).then(response=>{
                    this.showMsg('info', response.data.msg, 'Сообщение')
                }).catch(error=>{
                    this.showMsg('warning', error, 'Сообщение')
                })
            },
            
            removeItems(){
                axios({
                    method: "GET",
                    url: '/delete/test/'+this.trashData.id,
                }).then(response=>{
                    this.showMsg('info', response.data.msg, 'Сообщение')
                    this.tuggleModal(null, 11);
                    this.getData()
                }).catch(error=>{
                    this.showMsg('warning', error, 'Сообщение')
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
            tuggleModal(item=null, stateModal){
                this.trashData = item;
                console.log(this.trashData)
                if(stateModal == 1){
                    this.ModalShowTrashRow=true
                }else if(stateModal == 11){
                    this.ModalShowTrashRow=false
                }
            },
        }
    }
</script>
