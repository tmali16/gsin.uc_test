<template>
    <b-container class="mt-3 d-print-none" fluid>
        <h2>Кандидаты на тестирование</h2>
        <b-row>
            <b-col cols="12" class="mb-3 ">
                <b-card class="rounded-0 border-0 shadow d-print-none" >
                    <b-button squared variant="primary btns-shadow" @click="CandiCreateModal = !CandiCreateModal">Новый кондидат</b-button>
                </b-card>
            </b-col>
            <b-col cols="12">
                <b-card class="rounded-0 border-0 shadow "  >
                    <b-tabs card content-class="bg-white p-0">
                            <b-tab title="Не сдавали" active no-body>
                                <data-table :data="NotPassedCandi()" :settings="settings" :testsList="Tests"></data-table>
                            </b-tab>
                            <b-tab title="Архив" no-body>
                                <data-table :data="PassedCandi()" :settings="settings" :testsList="Tests"></data-table>
                            </b-tab>
                    </b-tabs>                    
                </b-card>
            </b-col>
        </b-row>
        <b-modal id="AddNewCandidate" title="Новый кандидат"  class="reounded-0 d-print-none" centered  v-model="CandiCreateModal">
            <b-row>
                <b-col class="">
                    <b-row class="mb-1">
                        <b-col sm="4" class=""><label>Фамилия*:</label></b-col>
                        <b-col><b-form-input id="" type="text" v-model="StoreData.fn" :state="FnState" size="sm"  @change="Required()" class="rounded-0" trim aria-describedby="input-live-help input-live-feedback"></b-form-input>
                        <b-form-invalid-feedback id="input-live-feedback">
                              Введите Фамилию
                        </b-form-invalid-feedback>
                        </b-col>
                    </b-row>
                    <b-row class="mb-1">
                        <b-col sm="4" class=""><label>Имя*:</label></b-col>
                        <b-col><b-form-input id="" type="text" v-model="StoreData.mn" size="sm" :state="MnState" class="rounded-0"  @change="Required()" required></b-form-input></b-col>
                    </b-row>
                    <b-row class="mb-1">
                        <b-col sm="4" class=""><label>Отчество:</label></b-col>
                        <b-col><b-form-input id="" type="text" v-model="StoreData.ln" size="sm" class="rounded-0"></b-form-input></b-col>
                    </b-row>
                    <b-row class="mb-1">
                        <b-col sm='4'>
                            <label for="">Тест для кондидата</label>
                        </b-col>
                        <b-col>
                            <b-form-select v-model="StoreData.test_id" :options="Tests" size="sm" :state="TestState"  class="rounded-0" @change="Required()"  value-field="id" text-field="title_ru"></b-form-select>
                        </b-col>
                    </b-row>
                </b-col>
            </b-row>
            <template v-slot:modal-footer>
                <div class="w-100">                    
                    <b-button size="sm" variant="success" class="rounded-0 float-right  ml-2" @click="store()" :disabled="Required()" >Сохранить</b-button>
                    <b-button variant="secondary" size="sm" class="rounded-0 float-right " @click="CandiCreateModal=false">
                        Close
                    </b-button>
                </div>
            </template>
        </b-modal>        
    </b-container>
</template>

<script>

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    export default {
        components: {
            'data-table':require("./DataTable.vue").default
        },
        data(){
            return {
                CandiCreateModal: false,                
                StoreData: {
                    fn: '',
                    mn: '',
                    ln: '',
                    test_id: '',
                },
                
                contents: [],
                Tests: [],
                data: null,
                settings: [],
            }
        },
        computed: {
            rows() {
                if(this.contents != null){
                    return this.contents.length
                }
            },
            FnState(){
                return this.StoreData.fn.length >= 2 ? true : false
            },
            MnState(){
                return this.StoreData.mn.length >= 2 ? true : false
            },
            TestState(){
                return this.StoreData.test_id != 0 ? true : false
            }
        },
        mounted() {
            this.getData()
        },
        methods:{
            getData: function () {
                axios.get("/candidate/get/").then(response =>{
                    this.contents = response.data.user
                    this.settings = response.data.settings
                }).catch(error=>{
                    console.log(error.data)
                })
                axios.get("/change/test/get/").then(response =>{
                    this.Tests = response.data
                }).catch(error=>{
                    console.log(error.data)
                })
            },
            store: function () {                
                axios({
                    method: "post",
                    url: "/candidate/add/new", 
                    data: this.StoreData
                }).then(response=>{
                    this.getData()
                    this.CandiCreateModal = false;                    
                    this.resetData()
                    this.showMsg('info', response.data.msg, 'Сообщение')                    
                }).catch(error=>{
                    this.showMsg('danger', error, 'Сообщение')
                })
            },
            CandiUpdate(row){
                axios({
                    method: "post",
                    url: "/update/candidate",
                    data: row.item
                }).then(response=>{
                    this.getData()
                    this.resetData()
                    row.toggleDetails()
                    this.showMsg('info', response.data.msg, 'Сообщение')
                }).catch(error=>{
                    this.showMsg('danger', error, 'Сообщение')
                })
            },
            Required(){
                var s = 0;
                if(this.StoreData.fn != null && this.StoreData.fn.length >= 2){s = 1;}else{ s = 0}
                if(this.StoreData.fn != null && this.StoreData.mn.length >= 2){s = 2;}else{s = 1}
                if(this.StoreData.fn != null && this.StoreData.test_id != 0){s = 3;}else{s = 2}                
                return s == 3 ? false : 'disabled';
            },
            State:function() {
                if(this.StoreData.fn.length >= 2) {return true}else{return false}
                if(this.StoreData.mn.length >= 2) {return true}else{return false}
                if(this.StoreData.test_id != 0) {return true}else{return false}
            },            
            showMsg(variant='info', text, title='Сообщение'){
                this.$bvToast.toast(text, {
                    title: title,
                    autoHideDelay: 5000,
                    variant: variant,
                    solid: true
                })
            },
            resetData(){
                this.StoreData.fn = '';
                this.StoreData.mn = '';
                this.StoreData.ln = '';
                this.StoreData.test_id = null;
            },
            PassedCandi(){
                return this.contents.filter(x=>x.passed == 1).sort((a, b)=>{
                    let dtA = new Date(a.created_at)
                    let dtB = new Date(b.created_at)
                    if(dtA > dtB) return -1;
                    if(dtA < dtB) return 1;
                    return 0;
                })
            },
            NotPassedCandi(){
                return this.contents.filter(x=>x.passed == 0).sort((a, b)=>{
                    let dtA = new Date(a.created_at)
                    let dtB = new Date(b.created_at)
                    if(dtA > dtB) return -1;
                    if(dtA < dtB) return 1;
                    return 0;
                })
            }
        }
    }
</script>
