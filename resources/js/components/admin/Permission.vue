<template>
<b-card class="border-0">
    <b-row>
        <b-col cols="12 mb-3">
            <b-card class="border-0">
                <b-button variant="success" @click="CreateModalSh">Создать полномочия</b-button>
            </b-card>
        </b-col>
        <b-col cols="12">
            <b-table :fields="head" :items="Permissions" :per-page="perPage" :current-page="CurrentPage" bordered>

            </b-table>
        </b-col>
        <b-col cols="12">
            <b-pagination v-model="CurrentPage" :total-rows="rows" :per-page="perPage" aria-controls="my-table"></b-pagination>
        </b-col>
    </b-row>
    <b-modal v-model="CreateModal" title="Создать " centered>
        <b-row class="mb-3">
            <b-col cols="4">Название полномочия:</b-col>
            <b-col ><b-form-input v-model="Data.name" placeholder="Название полномочия" size="sm"></b-form-input></b-col>
        </b-row>
        <template v-slot:modal-footer>
            <b-button @click="CloseModal">Отмена</b-button>
            <b-button variant="success" @click="Store">Создать</b-button>
        </template>
    </b-modal>
</b-card>
</template>

<script>
    export default {
        data(){
            return{
                CreateModal: false,
                perPage: 10,
                CurrentPage: 1,
                head: [{label:"Название", key:"name"},{label:"Название", key:"guard_name"},],
                Permissions:[],
                Auth: [],
                Data: {
                    name: '',
                    guard_name: ''
                }
            }
        },
        computed:{
            rows(){
                return this.Permissions.length
            }
        },
        mounted() {
            this.getPermission()
        },
        methods:{
            getPermission(){
                axios.get("/permission/get").then(respons=>{
                    this.Permissions = respons.data.Permissions;
                    this.Auth = respons.data.Auth
                }).catch(error=>{
                    console.log(error)
                })
            },
            Store(){
                axios.post("/permission/store", 
                this.Data).then(respons=>{
                    this.getPermission()
                    this.showMsg('info', respons.data.msg);
                    this.CloseModal();
                }).catch(error=>{
                    this.showMsg('info', error);
                })
            },
            CreateModalSh(){
                this.CreateModal = true;
                this.Data.guard_name = ''
                this.Data.name = ''
            },
            CloseModal(){
                this.CreateModal = false;
                this.Data.guard_name = ''
                this.Data.name = ''
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
