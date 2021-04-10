<template>    
    <b-row class="col" @dblclick="edit=!edit">
        <b-col cols="12" class="">
            <b-row class="mb-3">                
                <b-col sm="6" class=""><b>Суроо<span style="color: red;">*</span>:</b></b-col>
                <b-col sm="6" class=""><b>Вопрос<span style="color: red;">*</span>:</b></b-col>
                <b-col cols="6">
                    <b-form-textarea v-model="question.question_kg" size="sm" required v-if="edit"></b-form-textarea>
                    <span v-else>{{question.question_kg}}</span>                    
                </b-col>                
                <b-col cols="6">
                    <b-form-textarea id="" type="text" v-model="question.question_ru" size="sm" required v-if="edit"></b-form-textarea>
                    <span v-else>{{question.question_ru}}</span>
                </b-col>
            </b-row>
            <hr class="border-top border-danger">
            <b-row class="mb-3" cols-md="12" :class="question.answer == 'A' ? 'bg-info text-white pt-2 pb-2' :''">
                <b-col xl="1" class=""><b>A)<span style="color: red;">*</span>:</b></b-col>
                <b-form-radio v-model="question.answer" v-if="edit" :name="'VariantRadios_'+question.id" value="A" required ></b-form-radio>
                <span v-else><b-icon icon="check-circle" class="text-center mt-1" variant="light" v-if="question.answer == 'A'"></b-icon></span>
                <b-col cols="5">
                    <b-form-textarea id="" type="text" v-model="question.a_kg" size="sm" v-if="edit"></b-form-textarea>
                    <span v-else>{{question.a_kg}}</span>                
                </b-col>
                <b-col cols="5">
                    <b-form-textarea id="" type="text" v-model="question.a_ru" size="sm" v-if="edit"></b-form-textarea>
                    <span v-else>{{question.a_ru}}</span>
                </b-col>
            </b-row>
            <b-row class="mb-3" :class="question.answer == 'B' ? 'bg-info text-white pt-2 pb-2' :''">
                <b-col xl="1" class=""><b>Б)<span style="color: red;">*</span>:</b></b-col>
                <b-form-radio v-model="question.answer" v-if="edit" :name="'VariantRadios_'+question.id" value="B" required></b-form-radio>
                <span v-else><b-icon icon="check-circle" class="text-center mt-1" variant="light" v-if="question.answer == 'B'"></b-icon></span>
                <b-col cols="5">
                    <b-form-textarea id="" type="text" v-model="question.b_kg" size="sm" required v-if="edit" ></b-form-textarea>
                    <span v-else>{{question.b_kg}}</span>
                </b-col>
                <b-col cols="5">
                    <b-form-textarea id="" type="text" v-model="question.b_ru" size="sm" required v-if="edit"></b-form-textarea>
                    <span v-else>{{question.b_ru}}</span>
                </b-col>
            </b-row>
            <b-row class="mb-3" v-if="question.c_kg" :class="question.answer == 'C' ? 'bg-info text-white pt-2 pb-2' :''">
                <b-col xl="1" class=""><b>В):</b></b-col>
                <b-form-radio v-model="question.answer" v-if="edit" :name="'VariantRadios_'+question.id" value="C"></b-form-radio>
                <span v-else><b-icon icon="check-circle" class="text-center mt-1" variant="light" v-if="question.answer == 'C'"></b-icon></span>
                <b-col cols="5">
                    <b-form-textarea id="" type="text" v-model="question.c_kg" size="sm" required v-if="edit"></b-form-textarea>
                    <span v-else>{{question.c_kg}}</span>
                </b-col>
                <b-col cols="5">
                    <b-form-textarea id="" type="text" v-model="question.c_ru" size="sm" v-if="edit"></b-form-textarea>
                    <span v-else>{{question.c_ru}}</span>
                </b-col>
            </b-row>
            <b-row class="mb-3" v-if="question.d_kg" :class="question.answer == 'D' ? 'bg-info text-white pt-2 pb-2' :''">
                <b-col xl="1" class=""><b>Г):</b></b-col>
                <b-form-radio v-model="question.answer" v-if="edit" :name="'VariantRadios_'+question.id" value="D"></b-form-radio>
                <span v-else><b-icon icon="check-circle" class="text-center mt-1" variant="light" v-if="question.answer == 'D'"></b-icon></span>
                <b-col cols="5">
                    <b-form-textarea id="" type="text" v-model="question.d_kg" size="sm" v-if="edit"></b-form-textarea>
                    <span v-else>{{question.d_kg}}</span>                
                </b-col>
                <b-col cols="5">
                    <b-form-textarea id="" type="text" v-model="question.d_ru" size="sm" v-if="edit"></b-form-textarea>
                    <span v-else>{{question.d_ru}}</span>
                </b-col>
            </b-row>
        </b-col>
        <b-col class="">
            <b-button size="sm" class="mt-5 mr-2 float-right text-light" variant="info" squared v-if="!edit" @click="edit = true">Изменить</b-button>
            <b-button size="sm" class="mt-5 mr-2 float-right" variant="" squared v-if="edit" @click="edit = false">Отменить</b-button>
            <b-button size="sm" class="mt-5 mr-2 float-right" variant="success" squared v-if="edit" @click="Update()">Сохранить</b-button>
            <b-button size="sm" class="mt-5 mr-2 float-right" variant="danger" squared v-if="edit" @click="DestroyQuestionModal()">Удалить</b-button>
        </b-col>
        <b-col cols="12" class="mt-5">
            <b-jumbotron text-variant="info" class="rounded-0 p-2" border-variant="info">
                <template v-slot:lead>Примечание</template>
                <hr class="my-4">
                <p>
                > Места отмеченные знаками <span style="color: red;">*</span> обязательны к заполнению
                </p>
            </b-jumbotron>
        </b-col>
        <b-modal ref="my-modal" hide-footer title="Удаление" centered v-model="ModalShowTrashQuest">
            <div class="d-block text-center">
                <h4>Вы действительно хотите удалить запись?</h4>
            </div>
            <b-button class="mt-3" variant="danger" block @click="Destroy()">Удалить</b-button>
            <b-button class="mt-2" variant="outline-secondary" block @click="!ModalShowTrashRow">Отменить</b-button>
        </b-modal>
    </b-row>
</template>

<script>
    import TestComp from './TestList.vue'
    var Qlist = require('./Question_list.vue')
    export default {
        props:{
            question: {},
            index: 0,
        },
        components:{
            Qlist,
        },
        data(){
            return{
                edit: false,
                selected: '1',
                ModalShowTrashQuest: false,
                NewQuestion: {
                    question_ru:'',
                    question_kg:'',
                    a_kg:'',
                    a_ru:'',
                    b_kg:'',
                    b_ru:'',
                    c_kg:'',
                    c_ru:'',
                    d_kg:'',
                    d_ru:'',
                }
            }
        },
        mounted(){
            
        },
        methods: {
            Update: function(){
                axios.post("/question/update", this.question
                ).then(response=>{
                    TestComp.methods.getData();
                    this.edit = false;
                    TestComp.methods.showMsg('info', response.data.msg, 'Сообщение')
                    Qlist.methods.QuestUpdate(this.question)
                }).catch(error=>{
                    TestComp.methods.showMsg('danger', error, 'Сообщение')
                })
            },
            Destroy: function(){
                axios.get("/delete/question/"+this.question.id).then(response=>{      
                    //TestComp.methods.getData();
                    this.ModalShowTrashQuest = false;
                    Qlist.methods.QuestSplice(this.index);
                    this.showMsg('info', response.data.msg, 'Сообщение')
                }).catch(error=>{
                    this.ModalShowTrashQuest = false;
                    this.showMsg('danger', error, 'Сообщение')
                })
            },
            getSelected(){
                return this.question.answer
            },
            DestroyQuestionModal(){
                this.ModalShowTrashQuest = true;
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
