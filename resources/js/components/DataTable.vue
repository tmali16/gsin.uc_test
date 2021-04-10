<template>
    <div>
        <div class="d-flex flex-row">
            
        </div>
        <b-table :fields="head" :items="data" :tbody-tr-class="ifNewCandi" responsive fixed bordered id="CandidateTable" :current-page="currentPage" :per-page="perPage" style="height: 600px;">
            <template v-slot:cell(passed)="row">
                {{ row.item.passed ? 'Сдал' :'ожидается' }}
            </template>
            <template v-slot:cell(test_id)="row">
                <template v-if="row.item.test">
                    <span :id="'tooltip-button-interactive'+row.item.id" data-toggle="tooltip" data-placement="top" :title="row.item.test.title_ru">{{ row.item.test.title_ru.substring(0, 10) }}...</span>                                
                </template>
            </template>
            <template v-slot:cell(submit)="row">
                <b-button  @click="row.toggleDetails" variant='info' class="rounded-0 pt-1 pb-1 pr-2 pl-2 btns-shadow"><b-icon icon="gear-wide-connected" size="sm" variant="light"></b-icon></b-button >
                <b-button  variant="danger" class="rounded-0 pt-1 pb-1 pr-2 pl-2 btns-shadow" @click="TrashCandiModal(row.item)"><b-icon icon="trash" size="sm"></b-icon></b-button >
                <b-button variant="success" size="sm" squared :disabled="row.item.passed == 0" @click="shResult(row.item.result, row.item)" data-toggle="modal" data-target="#ResultMoadl"> <b-icon icon="eye"></b-icon> </b-button>
            </template>
            <template v-slot:row-details="row">
                <b-card>
                    <h5>Настройки</h5>
                    <b-row>
                        <b-col class="text-sm-right" sm="5">
                            <b-row class="mb-1">
                                <b-col sm="5" class="text-sm-right"><b>Фамилия:</b></b-col>
                                <b-col><b-form-input id="" type="text" v-model="row.item.fn" size="sm" ></b-form-input></b-col>
                            </b-row>
                            <b-row class="mb-1">
                                <b-col sm="5" class="text-sm-right"><label for="textarea-small">Имя:</label></b-col>
                                <b-col>
                                    <b-form-input id="textarea-small" size="sm" placeholder="Описание" v-model="row.item.mn"></b-form-input>
                                </b-col>
                            </b-row>
                            <b-row class="mb-1">
                                <b-col sm="5" class="text-sm-right"><b>Отчество:</b></b-col>
                                <b-col>
                                    <b-form-input v-model="row.item.ln" size="sm"></b-form-input>
                                </b-col>
                            </b-row>
                            <b-row class="mb-1">
                                <b-col sm="5" class="text-sm-right"><b>Персональный код:</b></b-col>
                                <b-col>
                                    <label   class="text-sm-left">{{row.item.code}}</label>
                                </b-col>
                            </b-row>
                        </b-col>
                        <!-- РУС -->
                        <b-col class="text-sm-left" sm="6">
                            <b-row class="mb-1">
                                <b-col sm="5" class="text-sm-right"><b>Набранный балл:</b></b-col>
                                <b-col><b-form-input id="" type="number" v-model="row.item.point" size="sm"  disabled></b-form-input></b-col>
                            </b-row>
                            <b-row class="mb-1">                                    
                                <b-col sm="5" class="text-sm-right"><b>Состояние:</b></b-col>
                                <b-col>{{row.item.passed}}</b-col>
                            </b-row>
                            <b-row class="mb-1">
                                <b-col sm="5" class="text-sm-right"><b>Тест:</b></b-col>
                                <b-col><b-form-select v-model="row.item.test_id" :options="testsList" size="sm" class="" value-field="id" text-field="title_ru"></b-form-select></b-col>
                            </b-row>
                            <b-row class="mt-2">
                                <b-col sm="5" class="text-sm-right"><b>Результат теста:</b></b-col>
                                <b-col><b-button variant="success" size="sm" squared :disabled="row.item.passed == 0" @click="shResult(row.item.result, row.item)" data-toggle="modal" data-target="#ResultMoadl">Посмотреть</b-button></b-col>
                            </b-row>
                        </b-col>
                    </b-row>
                    <b-button size="sm" variant="success" class="rounded-0 float-right  ml-2 mt-2" @click="CandiUpdate(row)" >Сохранить</b-button>
                    <b-button size="sm" @click="row.toggleDetails" class="rounded-0 float-right mt-2">Закрыть</b-button>
                </b-card>
            </template>
            <template v-slot:empty>
                <h4>Кандитадаты не добавлены</h4>
            </template>
        </b-table>
        <b-col v-if="data.length > 10">
            <div class="w-100 d-flex flex-row justify-content-between">
                <b-pagination v-model="currentPage" 
                    :per-page="perPage" pills 
                    :total-rows="rows" class="w-25" aria-controls="CandidateTable"></b-pagination>
                    <b-form-select v-model="perPage" 
                        :options="selectPerPage" size="sm" value-field="value" text-field="name" class="w-25">
                    </b-form-select>
            </div>
        </b-col>
        <b-modal v-model="ModalShow" size="xl" class="d-print-none w-100 border-0" hide-header>
            <result-vue :data="result" :candidate="candidate" :settings="settings" title="Отчет"  ></result-vue>
            <template v-slot:modal-footer class="d-print-none">
                <b-button variant="secondary" size="sm" class="rounded-0 float-right d-print-none" @click="ModalShow=false">
                    Close
                </b-button>
            </template>
        </b-modal>
        <b-modal ref="my-modal" hide-footer title="Удаление" v-model="ModalShowTrashRow">
            <div class="d-block text-center">
                <h3>Вы действительно хотите удалить  {{TrashData != null ? "тест "+TrashData.fn + " " + TrashData.mn + " " + TrashData.ln : 'запись'}}?</h3>
            </div>
            <b-button class="mt-3" variant="danger" block @click="Remove()">Удалить</b-button>
            <b-button class="mt-2" variant="outline-secondary" block @click="ModalShowTrashRow = false">Отменить</b-button>
        </b-modal>
    </div>
</template>

<script>
    export default {
        props:[
            'data',
            "settings",
            "testsList"
        ],
        data(){
            return{
                ModalShow: false,
                result: null,
                candidate: null,
                head: [
                    {label: 'Фамилия',key: 'fn',sortable: true},
                    {label: 'Имя',key: 'mn',sortable: true},
                    {label: 'Отчество',key: 'ln',sortable: false},
                    {label: 'Персональный код',key:'code',sortable: false},
                    {label: 'Балл',key: 'point',sortable: true},
                    {label: 'Состояние',key: 'passed',sortable: false},
                    {label: 'Тест',key: 'test_id',sortable: false},
                    {lable: "Событие",key:'submit'}
                ],
                selectPerPage: [{value:10, name: '10'},{value:30, name: '30'},{value:50, name: '50'},],
                currentPage: 1,
                perPage: 10,
                TrashData: '',                
                ModalShowTrashRow: false,                
            }
        },
        computed: {
            rows() {
                if(this.data != null){
                    return this.data.length
                }
            },            
        },
        mounted() {
            
        },
        methods:{
            shResult(result, intem){
                this.result = JSON.parse(result)
                this.candidate = intem
                this.ModalShow = true;
            },
            Remove(){
                axios({
                    method: "get",
                    url: "/delete/candidate/"+this.TrashData.id,
                }).then(response=>{
                    this.getData()
                    this.ModalShowTrashRow = false;
                    this.TrashData = [];
                    this.showMsg('info', response.data.msg, 'Сообщение')
                }).catch(error=>{
                    this.showMsg('danger', response.data.msg, 'Сообщение')
                })
            },
            TrashCandiModal(item){
                this.ModalShowTrashRow =true;
                this.TrashData = item;
            },
            ifNewCandi(item, type){
                const dt = new Date()
                const crted = new  Date(item.created_at)
                // if(!item || type !== "row") return
                console.log()
                let curDT = new Date(dt.getDate().toString()+"."+dt.getMonth()+"."+dt.getFullYear())
                let crtDT = new Date((crted.getDay()+3)+"."+crted.getMonth()+"."+crted.getFullYear());
                if(crtDT >= curDT){
                    return "table-success"
                } 
            }
        },
        
    }
</script>
