<template>
    <div class="container mb-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Mensagens</div>

                    <div class="card-body">
                        <div class="alert alert-info" v-if="mensagens.length <= 0">Nenhuma mensagem</div>
                        <p v-for="(mensagem, index) in mensagens" :key="index" class="text-left">
                            <strong>{{ mensagem.titulo }}</strong><br />
                            {{ mensagem.mensagem }}<br />
                            <small>{{ mensagem.created_at }}</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'usrId',
            'company'
        ],
        data() {
            return {
                mensagens: []
            }
        },
        mounted() {

            Echo.private('mensagem-'+ this.company +'.'+ this.usrId)
            .listen('EnviarMensagem', (e) => {
                console.log(e);
                this.mensagens.push(e)
            });
        }
    }
</script>
