@component('admin::layouts.app')
<!-- Content Wrapper. Contains page content -->
<div class="content">
    <div class="content-wrapper">
       <!-- Content Header (Page header) -->
       <div class="content-header">
         <div class="container-fluid">
           <div class="row mb-2">
             <div class="col-sm-6">
               <h1 class="m-0">Dashboard</h1>
             </div><!-- /.col -->
             <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                 <li class="breadcrumb-item"><a href="#">Home</a></li>
                 <li class="breadcrumb-item active">Dashboard</li>
               </ol>
             </div><!-- /.col -->
           </div><!-- /.row -->
         </div><!-- /.container-fluid -->
       </div>
       <!-- /.content-header -->

       <!-- Main content -->
       <section class="content p-3">
         <div class="container-fluid text-white">
           <!-- Small boxes (Stat box) -->
           <div class="row">
             <div class="col-lg-3 col-6">
               <!-- small box -->
               <div class="small-box bg-info p-3">
                 <div class="inner">
                   <h2>Rankings</h2>

                   <p>Best two participants in the competition</p>
                 </div>
                 <div class="icon">
                    <i class="ion ion-person-add"></i>
                 </div>
                 <a href="#" class="small-box-footer text-white">More info <i class="fas fa-arrow-circle-right"></i></a>
               </div>
             </div>
             <!-- ./col -->
             <div class="col-lg-3 col-6">
               <!-- small box -->
               <div class="small-box bg-success p-3">
                 <div class="inner">
                   <h2>Certificates<sup style="font-size: 20px"></sup></h2>

                   <p>All participants get certificates</p>
                 </div>
                 <div class="icon">
                    <i class="ion ion-person-add"></i>
                 </div>
                 <a href="#" class="small-box-footer text-white">More info <i class="fas fa-arrow-circle-right"></i></a>
               </div>
             </div>
             <!-- ./col -->
             <div class="col-lg-3 col-6">
               <!-- small box -->
               <div class="small-box bg-warning p-3">
                 <div class="inner">
                   <h2>Challenges </h2>

                   <p>The highly passed Challenges</p>
                 </div>
                 <div class="icon">

                   <i class="ion ion-stats-bars"></i>
                 </div>
                 <a href="#" class="small-box-footer text-white">More info <i class="fas fa-arrow-circle-right"></i></a>
               </div>
             </div>
             <!-- ./col -->
             <div class="col-lg-3 col-6">
               <!-- small box -->
               <div class="small-box bg-danger p-3">
                 <div class="inner">
                   <h2>Schools</h2>

                   <p>The leading schools in the competition</p>
                 </div>
                 <div class="icon">
                   <i class="ion ion-pie-graph"></i>
                 </div>
                 <a href="#" class="small-box-footer text-white">More info <i class="fas fa-arrow-circle-right"></i></a>
               </div>
             </div>
             <!-- ./col -->
           </div>
           <!-- /.row -->
           <!-- Main row -->

           <!-- /.row (main row) -->
         </div><!-- /.container-fluid -->
       </section>

       <!-- /.content -->
     </div>

   </div>

  <!-- /.content-wrapper -->



    <h3>Features :</h3>
    <ul>
        <li>Create an Account.</li>
        <li>Log In to view the dashboard </li>
        <li>Upload Questions and Answers.</li>
        <li>Create challenge and set parameters</li>
    </ul>

    <p>Get to know more  : <a href="#">About</a> Us</p>



@endcomponent
