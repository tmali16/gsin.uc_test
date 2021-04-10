<template fluid>
    <b-row class="justify-content-center h-100 mb-5">
        <b-col cols="4" style="height: 300px">
            <b-card class="text-center d-flex " style="height: 300px" bg-variant="success">
                <b-avatar variant="primary" class="align-items-center " :text="TestCount.toString()" size="10rem" ></b-avatar>
                
                <template v-slot:footer style="color: #fff">
                    <label class="text-white" style="color: #fff">Всего тестов</label>
                </template>
            </b-card>
        </b-col>
        <b-col cols="4" style="height: 300px">
            <b-card class="text-center d-flex " style="height: 300px">
                <b-avatar variant="primary" class="align-items-center " :text="CandiCount.toString()" size="10rem" ></b-avatar>
                
                <template v-slot:footer>
                    <label class="">Всего кандидатов</label>
                </template>
            </b-card>
        </b-col>
        <b-col cols="4" style="height: 300px">
            <b-card class="text-center d-flex " style="height: 300px">
                <b-avatar variant="primary" class="align-items-center " :text="QuestCount.toString()" size="10rem" ></b-avatar>                
                <template v-slot:footer>
                    <label class="" >Всего вопросов</label>
                </template>
            </b-card>
        </b-col>
    </b-row>
</template>

<script>
    export default {
        data(){
            return{
                TestCount: 0,
                CandiCount: 0,
                QuestCount: 0,

            }
        },
        mounted() {
            this.fetchData()
        },
        methods:{
            fetchData(){
                axios.get("/get/dashboard").then(respons=>{
                    this.TestCount = respons.data.TestCount
                    this.CandiCount = respons.data.CandiCount
                    this.QuestCount = respons.data.QuestCount
                }).catch(error=>{
                    console.log(error)
                })
            }
        }
    }
</script>
