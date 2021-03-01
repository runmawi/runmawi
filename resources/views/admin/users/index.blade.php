@extends('admin.master')

@section('content')
  <div id="content-page" class="content-page">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title">User Lists</h4>
                           </div>
                        </div>
                        <div class="iq-card-body">
                           <div class="table-view">
                              <table class="data-tables table movie_table" style="width:100%">
                                 <thead>
                                    <tr>
                                       <th style="width: 10%;">Profile</th>
                                       <th style="width: 10%;">Name</th>
                                       <th style="width: 20%;">Contact</th>
                                       <th style="width: 20%;">Email</th>
                                       <th style="width: 10%;">Country</th>
                                       <th style="width: 10%;">Status</th>
                                       <th style="width: 10%;">Join Date</th>
                                       <th style="width: 10%;">Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <td>
                                          <img src="../assets/images/user/01.jpg" class="img-fluid avatar-50" alt="author-profile">
                                       </td>
                                       <td>Anna Sthesia</td>
                                       <td>0123456789</td>
                                       <td>anna@gmail.com</td>
                                       <td>India</td>
                                       <td><span class="badge iq-bg-success">Active</span></td>
                                       <td>21 Jul, 2020</td>
                                       <td>
                                          <div class="flex align-items-center list-user-action">
                                             <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="#"><i
                                                class="ri-pencil-line"></i></a>
                                                <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="#"><i
                                                   class="ri-delete-bin-line"></i></a>
                                                </div>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td>
                                                <img src="../assets/images/user/03.jpg" class="img-fluid avatar-50" alt="author-profile">
                                             </td>
                                             <td>Brock Lee</td>
                                             <td>2586253125</td>
                                             <td>brock@gmail.com</td>
                                             <td>India</td>
                                             <td><span class="badge iq-bg-primary">Block</span></td>
                                             <td>12 Jun, 2020</td>
                                             <td>
                                                <div class="flex align-items-center list-user-action">                                             
                                                   <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="#"><i
                                                      class="ri-pencil-line"></i></a>
                                                      <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="#"><i
                                                         class="ri-delete-bin-line"></i></a>
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <img src="../assets/images/user/05.jpg" class="img-fluid avatar-50" alt="author-profile">
                                                   </td>
                                                   <td>Nick Allen</td>
                                                   <td>6523456856</td>
                                                   <td>nick@gmail.com</td>
                                                   <td>India</td>
                                                   <td><span class="badge iq-bg-warning">Pending</span></td>
                                                   <td>10 Aug, 2020</td>
                                                   <td>
                                                      <div class="flex align-items-center list-user-action">
                                                         <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="#"><i
                                                            class="ri-pencil-line"></i></a>
                                                            <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="#"><i
                                                               class="ri-delete-bin-line"></i></a>
                                                            </div>
                                                         </td>
                                                      </tr>
                                                      <tr>
                                                         <td>
                                                            <img src="../assets/images/user/08.jpg" class="img-fluid avatar-50" alt="author-profile">
                                                         </td>
                                                         <td>Lynn Guini</td>
                                                         <td>2563456589</td>
                                                         <td>lynn@gmail.com</td>
                                                         <td>India</td>
                                                         <td><span class="badge iq-bg-success">Active</span></td>
                                                         <td>29 Jul, 2020</td>
                                                         <td>
                                                            <div class="flex align-items-center list-user-action">
                                                               <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="#"><i
                                                                  class="ri-pencil-line"></i></a>
                                                                  <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="#"><i
                                                                     class="ri-delete-bin-line"></i></a>
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>
                                                                  <img src="../assets/images/user/06.jpg" class="img-fluid avatar-50" alt="author-profile">
                                                               </td>
                                                               <td>Eric Shun</td>
                                                               <td>5625456589</td>
                                                               <td>eric@gmail.com</td>
                                                               <td>India</td>
                                                               <td><span class="badge iq-bg-primary">Block</span></td>
                                                               <td>01 Aug, 2020</td>
                                                               <td>
                                                                  <div class="flex align-items-center list-user-action">
                                                                     <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="#"><i
                                                                        class="ri-pencil-line"></i></a>
                                                                        <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="#"><i
                                                                           class="ri-delete-bin-line"></i></a>
                                                                        </div>
                                                                     </td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td>
                                                                        <img src="../assets/images/user/10.jpg" class="img-fluid avatar-50" alt="author-profile">
                                                                     </td>
                                                                     <td>Marge Arita</td>
                                                                     <td>2563456589</td>
                                                                     <td>marge@gmail.com</td>
                                                                     <td>India</td>
                                                                     <td><span class="badge iq-bg-warning">Pending</span></td>
                                                                     <td>09 May, 2020</td>
                                                                     <td>
                                                                        <div class="flex align-items-center list-user-action">
                                                                           <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="#"><i
                                                                              class="ri-pencil-line"></i></a>
                                                                              <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="#"><i
                                                                                 class="ri-delete-bin-line"></i></a>
                                                                              </div>
                                                                           </td>
                                                                        </tr>
                                                                     </tbody>
                                                                  </table>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>


	@section('javascript')

	<script>

		$ = jQuery;
		$(document).ready(function(){
			$('.delete').click(function(e){
				e.preventDefault();
				if (confirm("Are you sure you want to delete this user?")) {
			       window.location = $(this).attr('href');
			    }
			    return false;
			});
		});

	</script>

	@stop

@stop

