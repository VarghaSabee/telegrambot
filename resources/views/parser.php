<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
 <div id="app">
 <h1>Insta images</h1>
 <p>Next page : {{next}}</p>
 <ol>
 <li v-for="img in images"><img :src="img"></li>
 </ol>
 </div>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.21/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
<script>
var app = new Vue({
    el:'#app',
    data () {
        return {
            images:[],
            next:"ok"
        }
    },
    mounted() {
        this.images = <?php echo $images; ?>;
        this.next =  '<?php echo $nextpage; ?>';
        // alert(this.images.length);
    },
});
</script>
</body>
</html>
