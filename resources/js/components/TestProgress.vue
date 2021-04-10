<template>
    <b-container class="h-100" fluid>
        <b-row class="h-100 justify-content-center align-items-center">
            <b-card class="h-75 w-75 d-flex border-0 rounded-0 shadow" body-class="p-0">
                <b-row class="h-100">					
					<b-col sm="9" class="h-100">
						<b-card  no-body class="border-0 p-3 h-100">							
							<b-container fluid class="h-100">
								<b-row class="h-100 jistify-content-center align-items-center">
									<b-col cols="12" class="h-75 d-flex justify-content-center align-items-center">
										<b-carousel ref="QuestionList" v-model="current"  no-wrap no-animation style="" class="w-100" :interval="100000000000000">
											<b-carousel-slide v-for="(item, i) in questions" :key="i" >
												<template v-slot:img>
													<h3>{{item.quest}}</h3>
													<hr>
													<b-form-radio-group stacked v-model="result" class="pl-2" style="font-size: 18px" >
														<b-form-radio :value="{'user_answer':'A', 'quest_id': item.id, 'index': i}" class="mt-3 mb-3 w-100" :class="selected=='A'?'bg-info p-2 ml-3 text-white':'' ">1) {{item.var_a}}</b-form-radio>
														<b-form-radio :value="{'user_answer':'B', 'quest_id': item.id, 'index': i}" class="mt-3 mb-3 w-100">2) {{item.var_b}}</b-form-radio>
														<b-form-radio v-if="item.var_c" :value="{'user_answer':'C', 'quest_id': item.id, 'index': i}" class="mt-3 mb-3 w-100">3) {{item.var_c}}</b-form-radio>
														<b-form-radio v-if="item.var_d" :value="{'user_answer':'D', 'quest_id': item.id, 'index': i}" class="mt-3 mb-3 w-100">4) {{item.var_d}}</b-form-radio>
													</b-form-radio-group>
												</template>
											</b-carousel-slide>
										</b-carousel>
									</b-col>
									<b-col cols="12" class="text-center">
										<b-row class="justify-content-center align-items-center">
										<b-col cols="2"  ><b-button squared size="sm" @click="Prev()" class="w-100 bg-secondary" :disabled="current == 0 ? 'disabled' : false"><b-icon icon="arrow-bar-left" variant="white"></b-icon></b-button></b-col>	
										<b-col cols="3"><b-button squared size="lg" @click="answerAdd()" class="w-100" variant="success" :disabled="result.user_answer.length == 0 ? 'disabled' :false"><b-icon icon="check-all"></b-icon></b-button></b-col>
										<b-col cols="2"><b-button squared size="sm" @click="Next()" class="w-100" :disabled="questions.length -1 == current ? 'disabled' : false"><b-icon icon="arrow-bar-right"></b-icon></b-button></b-col>
										</b-row>
									</b-col>
								</b-row>
							</b-container>
						</b-card>
					</b-col>
					<b-col sm="3" class="h-100">
						<b-card no-body class="bg-info h-100 border-0 rounded-0 text-center">
							<countdown :time="test_timer" @end="countdownEnd" @progress="countdownProgress" :transform="transform" class="text-center text-white" style="font-size: 52px">
								<template slot-scope="times"> {{ times.minutes }}:{{ times.seconds }}</template>
							</countdown>
							<span class=" border-top border-white"></span>
							<b-container fluid class="mt-2">
								<b-row class="justify-content-center">
									<b-col cols="12">
										<strong><b>Тест:</b></strong> <em>{{' '+tests.title}}</em> 
										<ul class="list-group border text-white p-2 list-group-flush striped mt-2">
											<li class="list-group-item bg-transparent  d-flex justify-content-between align-items-center">											
												{{lang == 'kg' ? "Cыноо мөөнөтү" : 'Длительность теста'}}
												<span>{{tests.timer}}&nbsp;мин.</span>
											</li>
											<li class="list-group-item bg-transparent d-flex justify-content-between align-items-center">
												{{lang == 'kg' ? "Суроолордун саны" : 'Количество вопросов'}}
												<span>{{tests.question_count}}</span>
											</li>
										</ul>
									</b-col>
									<b-col cols="12" class="mt-3">
										<h4 class="text-white">Прогресс</h4>	
									</b-col>
									<b-avatar v-for="(i) in tests.question_count" :key="i" :text="(i).toString()" :class="(answers.length == i-1 ? 'border border-white' : 'border-0')" :variant="answers[i-1] != undefined ?'success':'dark'"  class="m-2"></b-avatar>
								</b-row>
							</b-container>
						</b-card>
					</b-col>
                </b-row>
            </b-card>
        </b-row>
    </b-container>
</template>

<script>
    export default {
        props: ["test"],
        data(){
            return{
                test_timer: 5000,
                questions: [],
                tests: [],
                answers: [],
				current: 0,
				current_time: 0,
                btn_name: "",
				student_id: 0,
				lang: 'ru',
                result: {
                    quest_id: '',
                    user_answer: '',
                },
            }
        },
        mounted() {
			this.init();
			
        },
        methods:{
			init(){
				if(this.$cookie.get("result")&&this.$cookie.get("result").length >2){
					this.answers = JSON.parse(this.$cookie.get("result"))
				}
				this.fetchQuestion();
			},
			SetCookie(){
				this.$cookie.set("result", JSON.stringify(this.answers), 1)				
			},
            fetchQuestion(){            
                axios.get("/get/question/"+this.test).then(response =>{
                    this.questions = response.data.questions;
                    this.tests = response.data.test;
                    this.btn_name = response.data.btn_name;
                    this.student_id = response.data.student_id;
					this.lang = (response.data.lang)
					this.setTimer()
					this.DeleteExisitInQuest();					
				}).catch(error=>{
                    console.log(error.data)
				})
			},
			answerAdd(){
				this.answers.push({
						question_id: this.result.quest_id,
						user_answer: this.result.user_answer,
						student_id: this.student_id,
						test_id: this.test
					});
				this.questions.splice(this.result.index, 1);
				this.Reset()
				$("#sendForm").trigger("reset");
				this.SetCookie();
				if(this.questions.length == 0){
					this.finishTest();
				}
			},
			Next(){
				this.$refs.QuestionList.next();
				this.Reset()
			},
			Prev(){
				this.$refs.QuestionList.prev();
				this.Reset()
			},
			Reset(){
				this.result.quest_id = 0
				this.result.user_answer = ''
				this.result.index = 0
			},
			finishTest(){
                const url = "/test/finish";
                axios.post(url+"/store", {
                    result: this.answers,
                    student_id: this.student_id
                }).then(response=>{
                    window.location.href = url;
                    this.$cookie.delete("time");
                    this.$cookie.delete("result")
                }).catch(error=>{
                    console.log(error.data)
                })
            },
            transform(props) {
                Object.entries(props).forEach(([key, value]) => {                    
                    const digits = value < 10 ? `0${value}` : value;
                    props[key] = `${digits}`;
                });
                return props;
			},
			setTimer(){
                if(this.$cookie.get("time")){
                    var i = this.$cookie.get("time");
                    this.test_timer =  parseInt(i)
                }else{
					this.test_timer = this.tests.timer * 60 * 1000
					this.$cookie.set("time", this.test_timer, 1)
				}
            },
            countdownProgress(data){
				this.current_time = data.totalMilliseconds
				this.$cookie.set("time", this.current_time, 1)
				this.test_timer = this.current_time
            },
            countdownEnd(data){
				this.finishTest()
            },
            DeleteExisitInQuest(){
				this.answers.forEach(x=>{
					const ind = (this.questions.findIndex(q=>q.id === x.question_id))
					this.questions.splice(ind, 1)
				})
			},
			selected(){
				return this.answers.user_answer
			}
        }
    }
</script>