<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
<script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
    <!-- <script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script> -->
    <style>
    body {
  background-color:#1d1d1d !important;
  font-family: "Asap", sans-serif;
  color:#989898;
  margin:10px;
  font-size:16px;
}

#demo {
  height:100%;
  position:relative;
  overflow:hidden;
}


.green{
  background-color:#6fb936;
}
        .thumb{
            margin-bottom: 30px;
        }

        .page-top{
            margin-top:85px;
        }


img.zoom {
    width: 100%;
    height: 200px;
    border-radius:5px;
    object-fit:cover;
    -webkit-transition: all .3s ease-in-out;
    -moz-transition: all .3s ease-in-out;
    -o-transition: all .3s ease-in-out;
    -ms-transition: all .3s ease-in-out;
}


.transition {
    -webkit-transform: scale(1.2);
    -moz-transform: scale(1.2);
    -o-transform: scale(1.2);
    transform: scale(1.2);
}
    .modal-header {

     border-bottom: none;
}
    .modal-title {
        color:#000;
    }
    .modal-footer{
      display:none;
    }

    </style>

</head>
<body>
 <div id="app">
    <!-- start -->


    <div class="container">
	<div class="row">


        <div class="col-md-12">
        <h4>Instagramm names Datatable</h4>
        <p  data-toggle="tooltip" title="Edit"><button style="width: 100%;" class="btn btn-success btn-lg" data-title="Add" data-toggle="modal" data-target="#edit" ><span class="glyphicon glyphicon-plus"> Add insta name</span></button></p>
<hr>
        <div class="table-responsive">
              <table id="mytable" class="table table-bordred table-striped">

                   <thead>
                   <th><input type="checkbox" id="checkall" /></th>
                   <th>Name</th>
                    <th>Active</th>
                     <th>Created</th>
                     <th>Activate</th>
                      <th>Edit</th>
                       <th>Delete</th>
                   </thead>
    <tbody>

    <tr v-for="link in links">
    <td><input type="checkbox" class="checkthis" /></td>
    <td><a target="_blank" rel="noopener noreferrer" :href="'https://www.instagram.com/' + link.name">{{link.name}}</a></td>
    <td>{{link.active}}</td>
    <td>{{link.created_at}}</td>

    <td><p v-if="link.active" data-placement="top" data-toggle="tooltip" title="Activate"><button v-on:click="activate(link.id)" class="btn btn-primary btn-xs" data-title="Activate" ><span class="glyphicon glyphicon-ok"></span></button></p></td>
    <td><p data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" ><span class="glyphicon glyphicon-pencil"></span></button></p></td>
    <td><p data-placement="top" data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" ><span class="glyphicon glyphicon-trash"></span></button></p></td>
    </tr>


    </tbody>

</table>

<div class="clearfix"></div>

            </div>

        </div>
	</div>
</div>


<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading">Add instagram name</h4>
      </div>
          <div class="modal-body">
             <div class="form-group">
            <input class="form-control " type="text" v-model="name" placeholder="insta name"><br>
                 <button  v-on:click="addName" type="button" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>Add</button>
            </div>
             </div>
          <div class="modal-footer ">
        <!-- <button  v-on:click="addName" type="button" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>Add</button> -->
      </div>
        </div>
    <!-- /.modal-content -->
  </div>
      <!-- /.modal-dialog -->
    </div>



    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
      </div>
          <div class="modal-body">

       <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this Record?</div>

      </div>
        <div class="modal-footer ">
        <button type="button" class="btn btn-success" ><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
      </div>
        </div>
    <!-- /.modal-content -->
  </div>
      <!-- /.modal-dialog -->
    </div>

<!-- end -->

<!-- images -->
 <!-- Page Content -->
 <div class="container page-top">
 <h3>Next images to post</h3>



<div class="row">

     <div class="col-lg-3 col-md-4 col-xs-6 thumb" v-for="image in images">
        <a :href="image.url" class="fancybox" rel="ligthbox">
            <img  :src="image.url" class="zoom img-fluid "  alt="">
        </a>
    </div>

</div>




</div>

 </div>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.21/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
<script>

$(document).ready(function(){
  $(".fancybox").fancybox({
        openEffect: "none",
        closeEffect: "none"
    });

    $(".zoom").hover(function(){

		$(this).addClass('transition');
	}, function(){

		$(this).removeClass('transition');
	});
});


$(document).ready(function(){
$("#mytable #checkall").click(function () {
        if ($("#mytable #checkall").is(':checked')) {
            $("#mytable input[type=checkbox]").each(function () {
                $(this).prop("checked", true);
            });

        } else {
            $("#mytable input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
        }
    });

    $("[data-toggle=tooltip]").tooltip();
});


var app = new Vue({
    el:'#app',
    data () {
        return {
            images:[],
            links:[],
            next:"ok",
            name:''
        }
    },
    methods: {
        activate: function(a_id){
            var res = '';
            axios.get('/activate/' + a_id).then(response => (
                res = response.data
            ));
            this.getData();
            this.getImages();


        },
        addName:function(){
            axios.get('/add', {
                params: {
                    name: this.name
                }
                }).then(response => (
               console.log(response.data)
            ));
                this.name = "";
            this.getData();

        },
        getData:function(){
            axios.get('/all').then(response => (
            this.links = response.data
            ));
        },
        getImages:function(){
            axios.get('/images').then(response => (
            this.images = response.data
            ));
        }
    },
    mounted() {
        this.getData();
        this.getImages();
    },
});
</script>
</body>
</html>
