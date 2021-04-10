<template>
    <b-container>
        <h1>Настройки</h1>
        
        <b-row class="mt-4">
            <b-col cols="12">
                <b-card variant="light" class="shadow-sm">
                    <b-tabs content-class="mt-3">
                        <b-tab title="Роли"  v-if="Can('role.create')" active>
                            <role-vue></role-vue>
                        </b-tab>
                        <b-tab title="Полномочия" v-if="Can('permission.create')">
                            <permission-vue></permission-vue>
                        </b-tab>
                        <b-tab title="Настройки" active v-if="Can('settings.create')">
                            <settings-edit :permission="permission"></settings-edit>
                        </b-tab>
                    </b-tabs>
                </b-card>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
    export default {
        data(){
            return{
                permission: []
            }
        },
        mounted(){
            this.getData()
            
        },
        methods:{
            getData: function () {
                axios.get("/permissions/get").then(response =>{
                    this.permission = response.data
                }).catch(error=>{
                    console.log(error.data)
                })
            },
            Can(perm){
                var s = this.permission.indexOf(perm);
                return s != -1 ? true : false
            }
        }

    }
</script>
