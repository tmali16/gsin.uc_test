<template>
    <b-container >
        <b-row>
            <b-col>
                <h1>Пользователи</h1>
            </b-col>
        </b-row>
        <b-row>                     
            <b-col cols='12'>
                <b-card bg-variant="" class="shadow-sm border-0 rounded-0">
                    <b-button @click="CreateUserModal=true" variant="success" squared v-if="can('users.create')">Новый пользователь</b-button>
                </b-card>
            </b-col>    
            <b-col cols='12' class="mt-4">
                <b-card  class=" rounded-0 border-0">
                    <b-table :fields="header" :items="users">
                        <template v-slot:cell(role)="row">
                            <b-badge variant="primary" class="rounded-0 ml-1" v-for="role in row.item.roles" :key="role.id">{{role.name}}</b-badge>
                        </template>
                        <template v-slot:cell(privilege)="row" >
                            <b-badge variant="primary" class="rounded-0 ml-1" v-for="privil in row.item.roles[0].permissions" :key="privil.id">
                                {{privil.name}}
                            </b-badge>
                        </template>
                        <template v-slot:cell(created_at)="row">
                            {{ row.item ? row.item.created_at : '' | moment("DD.MM.Y HH:mm:ss") }}
                        </template>
                        <template v-slot:cell(submit)="row" class="colWidth">
                            <b-button  v-model="row.item.state" @click="row.toggleDetails" variant='info' size="sm" v-if="can('users.update')"><b-icon icon="gear-wide-connected" size="sm" variant="light"></b-icon></b-button >
                            <b-button  v-model="row.item.state" @click="" variant="danger" size="sm" v-if="can('users.delete')"><b-icon icon="trash" size="sm"></b-icon></b-button >
                        </template>
                        <template v-slot:row-details="row">                    
                            <b-card>
                                <b-row>                                    
                                    <b-col class="" sm="5">
                                        <b-row class="mb-1">
                                            <b-col sm="3" class=""><b>Имя:</b></b-col>
                                            <b-col><b-form-input id="" type="text" v-model="row.item.name" size="sm" ></b-form-input></b-col>
                                        </b-row>
                                        <b-row class="mb-1">
                                            <b-col sm="3" class=""><b>Почта:</b></b-col>
                                            <b-col><b-form-input id="" type="email" v-model="row.item.email" size="sm" ></b-form-input></b-col>
                                        </b-row>
                                        <b-row class="mb-1">
                                            <b-col sm="3" class=""><b>Роль:  </b></b-col>
                                            <b-col>
                                                <b-form-select v-model="row.item.roles[0].id" :options="roles" size="sm" class="" value-field="id" text-field="name"></b-form-select>
                                            </b-col>
                                        </b-row>
                                        
                                    </b-col>                                    
                                    <b-col class="" sm="7">
                                        <b-row>
                                            <b-col sm="3" class=""><b>Привилеги:</b></b-col>
                                            <b-col>
                                                <b-badge variant="primary" class="rounded-0 ml-1" v-for="privil in row.item.roles[0].permissions" :key="privil.id">
                                                    {{privil.name}}
                                                </b-badge>
                                            </b-col>
                                        </b-row>
                                    </b-col>
                                    <b-col sm="12">
                                        <b-row>
                                            <b-button @click="UpdateUser(row.item)" size="sm">Сохранить</b-button>
                                        </b-row>
                                    </b-col>
                                </b-row>
                            </b-card>
                            
                        </template>
                        
                    </b-table>
                </b-card>
            </b-col>                
        </b-row>       
        <b-modal id="modal-1" title="Регистрация пользователя" centered v-model="CreateUserModal">
            <b-col>
                <b-row class="mb-1">
                    <b-col sm="3">Имя</b-col>
                    <b-col><b-form-input id="s" type="text" v-model="CreateData.name" size="sm" :required="true" autocomplete="" ></b-form-input></b-col>
                </b-row>
                <b-row class="mb-1">
                    <b-col sm="3">Логин</b-col>
                    <b-col><b-form-input id="s" type="text" v-model="CreateData.username" size="sm" :state="UsernameState" @update="CheckUserName" aria-describedby="input-live-help input-live-feedback"> </b-form-input>
                    <b-form-invalid-feedback id="input-live-feedback">Имя пользователя занято</b-form-invalid-feedback></b-col>
                </b-row>
                <b-row class="mb-1">
                    <b-col sm="3">Почта</b-col>
                    <b-col><b-form-input id="s" type="email" v-model="CreateData.email" size="sm" ></b-form-input></b-col>
                </b-row>
                <b-row class="mb-1">
                    <b-col sm="3" class=""><b>Роль:  </b></b-col>
                    <b-col>
                        <b-form-select v-model="CreateData.role" :options="roles" size="sm" class="" value-field="id" text-field="name"></b-form-select>
                    </b-col>
                </b-row>
            </b-col>
            <template v-slot:modal-footer>
                <b-button variant="success" size="sm" @click="UserCreate">Создать</b-button>
                <b-button size="sm" @click="CreateUserModal=false">Отмена</b-button>
            </template>
        </b-modal> 
    </b-container>
</template>

<script>
    export default {
        data(){
            return{
                PrivilegeModal: false,
                CreateUserModal: false, 
                header: [
                    {label: 'Имя',key: 'name',sortable: true},{label: 'Логин',key: 'username',sortable: true},{label: 'почта',key: 'email',sortable: false},{label: 'Дата создания',key: 'created_at',sortable: true},
                    {label: 'Роль',key: 'role',sortable: true},{label: 'Привилегии',key: 'privilege',sortable: false},{label: 'События',key: 'submit',sortable: false},],
                options: [{}],
                users: [],
                roles: [],
                permissions: [],
                Auth: [],
                CreateData:{
                    name: '',
                    username: '',
                    email: '',
                    role: 0,
                },
                UsernameState: null,
            }
        },
        mounted() {
            this.getUser()
        },
        methods:{
            getUser(){
                // if(this.can('users.read')){
                    axios.get("/get/user").then(respons=>{
                        this.users = respons.data.Users;
                        this.roles = respons.data.Roles;
                        this.permissions = respons.data.Permissions;
                        this.Auth = respons.data.Auth
                    }).catch(error=>{
                        console.log(error)
                    })
                // }else{
                    // console.log("Доступ закрыт")
                // }
            },
            UserCreate(){
                axios({
                    method: "POST",
                    url: '/create/user',
                    data: this.CreateData
                }).then(response=>{
                    this.CreateUserModal = false;
                    this.showPass('info', response.data.pass);
                    this.showMsg('info', response.data.msg);
                    this.getUser();
                    this.resetData()
                }).catch(error=>{
                this.showMsg('warning', error);
                })
            },
            UpdateUser(item){
                axios({
                    method: "POST",
                    url: '/update/user',
                    data: item
                }).then(response=>{
                    this.showMsg('info', response.data.msg);
                    this.getUser();
                    
                }).catch(error=>{
                this.showMsg('warning', error);
                })
            },
            CheckUserName(){
                if(this.CreateData.username.length > 3){                    
                    axios.get("/check/username/"+this.CreateData.username).then(respons=>{
                        this.UsernameState =  respons.data
                    }).catch(error=>{
                        console.log(error)
                        this.UsernameState = false;
                    })
                    $("#input-live-feedback").text("Имя пользователя занято");
                }else{
                    $("#input-live-feedback").text("больше 3 символов");
                    this.UsernameState = false
                }
            },
            ShowModal(item){
                this.PrivilegeModal= true;
                this.currData = item.permissions
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
                this.CreateData.name = ''
                this.CreateData.username = ''
                this.CreateData.email = ''
                this.CreateData.role = 0
            },
            showPass(variant='info', text, title='Сообщение'){
                this.$bvToast.toast("Пароль: "+text, {
                    title: title,
                    toaster:'b-toaster-top-center',
                    noAutoHide: false,
                    solid: true
                })
            },
            can(name){
                return (this.Auth.indexOf(name) != -1 ? true : false);
            }
        }
    }
</script>
