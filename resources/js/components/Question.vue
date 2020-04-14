<template>
    <div class="container h-100">
        <div class="row h-100 justify-content-center">
            <div class="col-md-12 text-center p-4" style="font-size: 24px; text-white" >
                <countdown :time="test_timer" @end="countdownEnd" @progress="countdownProgress">
                        <template slot-scope="props"> {{ props.minutes }}:{{ props.seconds }}</template>
                </countdown>
            </div>
            <div class="col-md-10 h-100 d-flex align-items-center justify-content-center">                
                <div class="card rounded-0 " style="width: 100%; height: 40%">
                    <div class="card-body">
                        <div class="col-md-12" v-for="(question,index) in questions" v-if="index == current">
                            <form action="#" v-on:submit.prevent="answerAdd(question.id)" id="sendForm">
                                    <h4>{{question.quest}}</h4> &nbsp; {{current+1}} / {{questions.length}}
                                    <hr>
                                    <div class="col-sm-12" id="questionVariants">
                                        <div class="form-check mb-2" v-if="question.var_a !== null">
                                            <input class="form-check-input" type="radio" name="gridRadios" v-model="result.user_answer" :id="'radio'+index" value="A" aria-checked="false">
                                            <label class="form-check-label col" :for="'radio'+index">
                                                {{question.var_a}}
                                            </label>
                                        </div>
                                        <div class="form-check mb-2" v-if="question.var_b !== null">
                                            <input class="form-check-input" type="radio" name="gridRadios" v-model="result.user_answer" :id="'radio'+index+1" value="B" aria-checked="false">
                                            <label class="form-check-label col"  :for="'radio'+index+1">
                                                {{question.var_b.length}}
                                            </label>
                                        </div>
                                        <div class="form-check mb-2" v-if="question.var_c !== null">
                                            <input class="form-check-input" type="radio" name="gridRadios" v-model="result.user_answer" :id="'radio'+index+2" value="C" aria-checked="false">
                                            <label class="form-check-label col" :for="'radio'+index+2">
                                                {{question.var_c}}
                                            </label>
                                        </div>
                                        <div  class="form-check mb-2" v-if="question.var_d != null">
                                            <input class="form-check-input" type="radio" name="gridRadios" v-model="result.user_answer" :id="'radio'+index+3" value="D" aria-checked="false">
                                            <label class="form-check-label col" :for="'radio'+index+3">
                                                {{question.var_d}} 
                                            </label>
                                        </div>
                                    </div>
                                <div class="col-md-9 mt-2">
                                    <a href="#" @click="prevQuest()" class="btn btn-sm btn-secondary rounded-0 mr-2"><</a>
                                    <button class="btn btn-sm btn-success rounded-0">{{btn_name}}</button>
                                    <a href="#" @click="nextQuest()" class="btn btn-sm btn-secondary rounded-0 ml-2">></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["test_id", "timer"],
        data(){
          return{
              questions: [],
              test: [],
              answers: [],
              result: {
                  question_id: "",
                  user_answer: 0,
                  student_id: 0,
                  test_id: '',
              },
              current: 0,
              btn_name: "",
              student_id: 0,
              test_timer: 0,
          }
        },
        mounted() {
            
        },
        created () {
            this.fetchQuestion()
            
        },
        methods:{
            fetchQuestion(){
            
                axios.get("/get/question/"+this.test_id).then(response =>{
                    this.questions = response.data.questions;
                    this.test = response.data.test;
                    this.btn_name = response.data.btn_name;
                    this.student_id = response.data.student_id;                    
                }).catch(error=>{
                    console.log(error.data)
                })                    
            
                this.setTimer()
            },
            setCookie(data){
                this.$cookie.set("questions", JSON.stringify(data.questions), 5)
                this.$cookie.set("test", JSON.stringify(data.test), 5)
                this.$cookie.set("btn_name", data.btn_name)
                this.$cookie.set("student_id", data.student_id, 5)
            },
            nextQuest(){
                if((this.questions.length-1) > this.current) {
                    $("#sendForm").trigger("reset");
                    this.current++;
                }
            },
            prevQuest(){
                if(this.questions.length > this.current && this.current > 0) {
                    $("#sendForm").trigger("reset");
                    this.current--;
                }

            },
            answerAdd(question_id, index){
                const usr_answ = (this.result.user_answer );
                this.answers.push({
                    question_id: question_id,
                    student_id: this.student_id,
                    user_answer: usr_answ,
                    test_id: this.test_id
                });
                this.questions.splice(index, 1);
                
                $("#sendForm").trigger("reset");
                if(this.questions.length === 0){
                    this.finishTest();
                }
                this.result.user_answer = 0;
            },
            finishTest(){
                const url = "/test/finish";
                axios.post(url+"/store", {
                    result: this.answers,
                    student_id: this.student_id
                }).then(response=>{
                    window.location.href = url;
                }).catch(error=>{
                    console.log(error.data)
                })
            },
            setTimer(){
                
                if(this.$cookie.get("time")){
                    var i = this.$cookie.get("time");
                    this.test_timer = parseInt(i)
                }else{
                    this.test_timer = this.timer * 60 * 1000
                }
                 
            },
            countdownProgress(data){
                this.$cookie.set("time", (data.minutes !=0 ? (data.minutes + 0) : 0) + data.seconds * 1000, 1)
                this.$cookie.set("result", JSON.stringify(this.answers), 1)
            },
            countdownEnd(data){
                this.$cookie.delete("time");
                //this.answers = this.$cookie.get("result")
                this.finishTest();
                this.$cookie.delete("result")
                //window.location.href = "/"
            }
        }
    }
</script>
