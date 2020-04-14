<template>
    <div class="container mt-5">
        <div class="row justify-content-center">

            <div class="col-md-12">
                
            </div>

            <b-table
                show-empty
                small
                stacked="md"
                :fields="fields"
                :items="data"
            >
                <template v-slot:cell(title_ru)="data">
                    {{data.item.title_ru}}
                </template>
                <template v-slot:cell(description_ru)="data">
                    {{data.item.description_ru}}
                </template>
            </b-table>
            
        </div>
    </div>
</template>

<script>
    export default {
        props:[
            "test_id"
        ],
        data(){
            return{
                fields:[
                    {key: 'title_ru', label: 'Название теста', sortable: true, sortDirection: 'desc'},
                    {key: 'description_ru', label: 'Описание', sortable: false, sortDirection: 'desc'},
                    {key: 'state', label: 'Состояние', sortable: false, sortDirection: 'desc'},
                    {key: 'timer', label: 'Длительность', sortable: false, sortDirection: 'desc'},
                    {key: 'question_count', label: 'Количество вопросов', sortable: false, sortDirection: 'desc'},
                ],
                items: [],
                data: [],
            }
        },
        mounted() {
            this.fetch()
        },
        methods: {
            fetch: function(){
                axios.get('/new/question/add/').then((response)=>{
                    this.data = response.data;
                }, (error)=>{
                    
                });
            }
        },
    }
</script>
