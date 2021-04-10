<template>    
    <b-tabs content-class="h-100 p-3 QuestionListContent" active-nav-item-class="tabactive" nav-class="questionList" pills vertical no-nav-style >
        <b-tab v-for="(item, index) in Test.question" :key="item.id" :active="index == 0" id="questionList">
            <template v-slot:title>
                {{index+1}})&nbsp;{{item.question_ru.substring(0, 18)+(item.question_ru.length > 18 ? "..." : "")}}
            </template>
            <questions-edit :question="Test.question[index]" :key="Test.question.length" :index="index"></questions-edit>
        </b-tab>
        <b-tab title="Добавить" title-link-class="addTab" id="questionList">
            <b-row class="col">
                <b-col cols="12" class="mb-3">
                    <h2 class="text-info">Создание вопроса</h2>
                </b-col>
                <b-col cols="12">
                    <b-row class="mb-2" cols-md="12">
                        <b-col offset-sm="1" sm="5" class=""><b>Суроо*:</b></b-col>
                        <b-col offset-sm="1" sm="5" class=""><b>Вопрос*:</b></b-col>
                        <b-col offset-sm="1" cols="6">
                            <b-form-textarea v-model="question.question_kg" size="sm" required></b-form-textarea>
                        </b-col>
                        <b-col cols="5">
                            <b-form-textarea id="" type="text" v-model="question.question_ru" size="sm" required></b-form-textarea>
                        </b-col>
                    </b-row>
                    <hr>
                    <b-row class="mb-3">
                        <b-col class=""><b>A)*:</b></b-col>
                        <b-form-radio v-model="question.answer" name="VariantsRadios" value="A" required ></b-form-radio>
                        <b-col cols="6">
                            <b-form-textarea id="" type="text" v-model="question.a_kg" size="sm" required></b-form-textarea>
                        </b-col>                        
                        <b-col cols="5">
                            <b-form-textarea id="" type="text" v-model="question.a_ru" size="sm" required></b-form-textarea>
                        </b-col>
                    </b-row>
                    <b-row class="mb-3">
                        <b-col class=""><b>Б)*:</b></b-col>
                        <b-form-radio v-model="question.answer" name="VariantsRadios" value="B" required ></b-form-radio>
                        <b-col cols="6"><b-form-input id="" type="text" v-model="question.b_kg" size="sm" required></b-form-input></b-col>
                        <b-col cols="5"><b-form-input id="" type="text" v-model="question.b_ru" size="sm" required></b-form-input></b-col>
                    </b-row>
                    <b-row class="mb-3">
                        <b-col class=""><b>В):</b></b-col>
                        <b-form-radio v-model="question.answer" name="VariantsRadios" value="C" required ></b-form-radio>
                        <b-col cols="6"><b-form-input id="" type="text" v-model="question.c_kg" size="sm" ></b-form-input></b-col>
                        <b-col cols="5"><b-form-input id="" type="text" v-model="question.c_ru" size="sm" ></b-form-input></b-col>
                    </b-row>
                    <b-row class="mb-3">
                        <b-col class=""><b>Г):</b></b-col>
                        <b-form-radio v-model="question.answer" name="VariantsRadios" value="D" required ></b-form-radio>
                        <b-col cols="6"><b-form-input id="" type="text" v-model="question.d_kg" size="sm" ></b-form-input></b-col>
                        <b-col cols="5"><b-form-input id="" type="text" v-model="question.d_ru" size="sm" ></b-form-input></b-col>
                    </b-row>
                </b-col>
                <!-- <b-col cols="6">
                    <b-row class="mb-2">
                        <b-col sm="2" class=""><b>Вопрос*:</b></b-col>
                        <b-col><b-form-textarea id="" type="text" v-model="question.question_ru" size="sm" required></b-form-textarea></b-col>
                    </b-row>
                    <hr>
                    <b-row class="mb-3">
                        <b-col sm="2" class=""><b>A)*:</b></b-col>
                        <b-col><b-form-input id="" type="text" v-model="question.a_ru" size="sm" required></b-form-input></b-col>
                    </b-row>
                    <b-row class="mb-3">
                        <b-col sm="2" class=""><b>Б)*:</b></b-col>
                        <b-col><b-form-input id="" type="text" v-model="question.b_ru" size="sm" required></b-form-input></b-col>
                    </b-row>
                    <b-row class="mb-3">
                        <b-col sm="2" class=""><b>В):</b></b-col>
                        <b-col><b-form-input id="" type="text" v-model="question.c_ru" size="sm" ></b-form-input></b-col>
                    </b-row>
                    <b-row class="mb-3">
                        <b-col sm="2" class=""><b>Г):</b></b-col>
                        <b-col><b-form-input id="" type="text" v-model="question.d_ru" size="sm" ></b-form-input></b-col>
                    </b-row>
                </b-col> -->
                <hr>
                <b-col cols="12" class="mt-3">
                    <b-button @click="Store()" class="mt-5 float-right" variant="success" squared>Сохранить</b-button>
                </b-col>
            </b-row>
        </b-tab>
        <template v-slot:empty>
          <div class="text-center text-muted">
            Данного теста вопросов нету<br>
            новый вопрос можно добавить кнопкой <b>"Добавить"</b>.
          </div>
        </template>
    </b-tabs>
</template>

<script>
    import TestComp from './TestList.vue'
    export default {        
        props:['tests'],
        data(){
            return {
                Test: this.tests,
                question:{
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
                    answer: '',
                }
            }
        },
        mounted() {
            
        },
        methods:{
            Store(){
                axios.post("/question/store/"+this.Test.id,
                    this.question
                ).then(response=>{
                    //TestComp.methods.getData();
                    this.reset()
                }).catch(error=>{
                    this.showMsg('danger', error, 'Сообщение')
                })
            },
            Update(){
                axios.post("", 
                    this.question
                ).then(response=>{
                    this.getData()
                    this.reset()
                }).catch(error=>{
                    this.showMsg('danger', error, 'Сообщение')
                })
            },
            QuestSplice(start){
                this.Test.question = this.Test.question.splice(start, 1)
                console.log(this.Test.question)
            },
            QuestPush(data){
                this.Test.question.push(data)
            },
            QuestUpdate(start, data){
                this.Test.question = this.Test.question.splice(start, 1, data)
            },
            reset(){
                question.question_ru = ''
                question.question_kg = ''
                question.a_kg = ''
                question.b_kg = ''
                question.c_kg = ''
                question.d_kg = ''
                question.a_ru = ''
                question.b_ru = ''
                question.c_ru = ''
                question.d_ru = ''
                question.answer = ''
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
