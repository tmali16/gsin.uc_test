<template>
    <b-container>
        <b-row>
            <b-col>
                <b-table :fields="head" striped bordered :items="Settings">
                    <template v-slot:cell(key)="row">
                        {{row.item.mark}}
                    </template>
                    <template v-slot:cell(lang)="row">
                        {{row.item.lang === 'ru' ? 'Русский язык' : 'Кыргыз тили'}}
                    </template>
                    <template v-slot:cell(submit)="row">
                        <b-button  @click="row.toggleDetails" variant='info' size="sm" v-if="can('settings.update')"><b-icon icon="gear-wide-connected" size="sm" variant="light"></b-icon></b-button >
                        <b-button  @click="" variant="danger" size="sm" v-if="can('settings.delete')"><b-icon icon="trash" size="sm"></b-icon></b-button >
                    </template>
                    <template v-slot:row-details="row">
                        <b-card>
                                <h6>Настройки</h6>
                                <b-row>
                                    <b-col class="text-sm-right" sm="5">
                                        <b-row class="mb-1">
                                            <b-col sm="6" class="text-sm-right"><b>{{row.item.mark}}:</b></b-col>
                                            <b-col><b-form-input id="" type="text" v-model="row.item.values" size="sm" ></b-form-input></b-col>
                                        </b-row>
                                        <b-row class="mb-1">
                                            <b-col sm="6" class="text-sm-right"><b>Язык:</b></b-col>
                                            <b-col><b-form-select disabled v-model="row.item.lang" :options="Lang" size="sm" class="" value-field="lang" text-field="title"></b-form-select></b-col>
                                        </b-row>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-button @click="Update(row)" variant="success">Сохранить</b-button>
                                </b-row>
                        </b-card>
                    </template>
                </b-table>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
    export default {
        props:[
            'permission'
        ],
        data(){
            return{
                head:[{label:"Ключь", key:"key"},{label:"значение", key:"values"},{label:"Язык", key:"lang"},{label:"Событие", key:"submit"},],
                Settings: [],
                Lang: [{lang: 'ru',title: 'Русский язык',},{lang: 'kg',title: 'Кыргыз тили',}]
            }
        },
        mounted() {
            this.getData()
        },
        methods:{
            getData: function () {
                axios.get("/Settings/get").then(response =>{
                    this.Settings = response.data
                }).catch(error=>{
                    console.log(error.data)
                })
            },
            Update(row){
                axios({
                    method: "post",
                    url: "/settings/edit", 
                    data: row.item
                }).then(response=>{
                    this.getData()
                    this.showMsg('info', response.data.msg, 'Сообщение')                    
                }).catch(error=>{
                    this.showMsg('danger', error, 'Сообщение')
                })
            },
            can(param){
                var s = this.permission.indexOf(param);
                return s != -1 ? true : false
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
