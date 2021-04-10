<template>
    <b-card class="border-0">
        <b-row>
            <b-col cols="12" class="mb-4">
                <b-button size="sm" variant="success" squared class="btns-shadow" @click="CreateModalSh">Создать роль</b-button>
            </b-col>
        </b-row>
        <b-table :fields="head" striped bordered :items="Roles">
            <template v-slot:cell(permission)="row">
                <b-badge v-for="(item, ind) in row.item.permissions" :key="ind" variant="success" class="mr-3">{{item.name}}</b-badge>
                <b-button size="sm" variant="info" @click="UpdateModalSh(row.item)" link><b-icon icon="plus-circle" variant="light"></b-icon></b-button>
            </template>
            <template v-slot:cell(submit)="row">
                <b-button  @click="" variant='info' size="sm" v-if="can('users.update')"><b-icon icon="gear-wide-connected" size="sm" variant="light"></b-icon></b-button >
                <b-button  @click="" variant="danger" size="sm" v-if="can('users.delete')"><b-icon icon="trash" size="sm"></b-icon></b-button >
            </template>
        </b-table>
        <b-modal v-model="UpdateModal">
            <b-form-checkbox-group
                v-model="RoleData.permissions" :options="Permissions" class="mb-3" value-field="id" text-field="name" >
            </b-form-checkbox-group>
            <template v-slot:modal-footer>
                <b-button @click="CloseUpdateRoleModal">Отмена</b-button>
                <b-button @click="StoreRole" variant="success">Ок</b-button>
            </template>
        </b-modal>
<!-- -------------------------------------------------------------------------------------------------------------------------------------- -->
        <b-modal v-model="CreateModal">
            <b-row class="mb-3">
                <b-col cols="3">Название роли:</b-col>
                <b-col ><b-form-input v-model="CreateRole.name" placeholder="Название роли" size="sm"></b-form-input></b-col>
            </b-row>
            <div class="border border-info"></div>
            <b-row class="mt-2 h-15" style="max-height: 200px">
                <b-col>
                    <b-form-group label="Полномочия роли">
                    <b-form-checkbox-group
                        v-model="CreateRole.permissions" :options="Permissions" class="mb-3" value-field="id" text-field="name" >
                    </b-form-checkbox-group>
                    </b-form-group>
                </b-col>
            </b-row>
            <template v-slot:modal-footer>
                <b-button @click="CloseUpdateRoleModal">Отмена</b-button>
                <b-button @click="CreateRoles()" variant="success">Сохранить</b-button>
            </template>
        </b-modal>
    </b-card>
</template>

<script>
    export default {
        data(){
            return{
                UpdateModal: false,
                CreateModal: false,
                head:[{label:"Роль", key:"name"},{label:"Привилегии", key:"permission"},{label:"Событие", key:"submit"},],
                Roles: [],
                Auth: [],
                Permissions: [],
                RoleData: {
                    role: 0,
                    permissions: []
                },
                CreateRole:{
                    name: '',
                    permissions:[]
                },
            }
        },
        mounted() {
            this.getRoles();
        },
        methods:{
            getRoles(){
                axios.get("/role/get").then(respons=>{
                    this.Roles = respons.data.Roles;
                    this.Permissions = respons.data.Permissions;
                    this.Auth = respons.data.Auth
                }).catch(error=>{
                    console.log(error)
                })
            },
            CreateModalSh(){
                this.CreateModal = true;
                this.CreateRole.name = '';
                this.CreateRole.permissions = [];
            },
            CreateRoles(){
                axios.post('/role/store', this.CreateRole
                ).then(response=>{
                    this.CreateModal= false;
                    this.CreateRole.name = '';
                    this.CreateRole.permissions = [];
                    this.showMsg('info', response.data.msg);
                    this.getRoles()
                }).catch(error=>{
                    this.showMsg('warning', error);
                })
            },
            CloseCreateModal(){
                this.CreateModal= false;
                this.CreateRole.name = '';
                this.CreateRole.permissions = [];
            },
            UpdateModalSh(item){
                this.UpdateModal= true;
                this.RoleData.role = item.id;
                item.permissions.forEach(element => {
                     this.RoleData.permissions.push(element.id)
                });
            },
            CloseUpdateRoleModal(){
                this.UpdateModal= false;
                this.Data = [];
            },
            StoreRole(){
                axios({
                    method: "POST",
                    url: '/role/assign/permission',
                    data: this.RoleData
                }).then(response=>{
                    this.UpdateModal= false;
                    this.RoleData.role = 0;
                    this.RoleData.permissions = [];
                    this.showMsg('info', response.data.msg);
                    this.getRoles()
                }).catch(error=>{
                    this.showMsg('warning', error);
                })
            },
            showMsg(variant='info', text, title='Сообщение'){
                this.$bvToast.toast(text, {
                    title: title,
                    autoHideDelay: 5000,
                    variant: variant,
                    solid: true
                })
            },
            can(permissions){
                return this.Auth.indexOf(permissions) != -1 ? true : false
            }
        }
    }
</script>
