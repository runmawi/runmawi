@extends('admin.master')

@include('admin.favicon')

    @section('css')
        <link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
    @endsection

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

{{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

@section('content')

<div id="content-page" class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title"> {{ 'Landing Page' }}</h4>
                        </div>
                    </div>
                    <div class="iq-card-body table-responsive">
                        <form  accept-charset="UTF-8" action="{{ route('landing_page_update') }}" method="post" >
                        @csrf
                        <fieldset>
                            <div class="form-card">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        
                                        <div class="row">
                                            <div class="col-sm-6 form-group" >
                                                <label class="m-0"> Title :</label>
                                                <input type="text"  class="form-control" name="title" id="title" placeholder=" Landing Page Title" value="{{ $title }}">
                                             </div>
    
                                            <div class="col-sm-6 form-group" >
                                                <label class="m-0"> Slug :</label>
                                                <input type="text"  class="form-control" name="slug" id="slug" placeholder=" Landing Page Slug" value="{{ $slug }}" >
                                             </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6 form-group" >
                                                <label class="m-0"> Meta Title :</label>
                                                <input type="text"  class="form-control" name="meta_title" id="meta_title" placeholder=" Landing Page Meta Title" value="{{ $meta_title }}">
                                             </div>
    
                                            <div class="col-sm-6 form-group" >
                                                <label class="m-0"> Meta Keywords :</label>
                                                <input type="text"  class="form-control" name="meta_keywords" id="meta_keywords" placeholder=" Landing Page Meta Keywords" value="{{ $meta_keywords }}">
                                             </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 form-group" >
                                                <label class="m-0"> Meta Description :</label>
                                                    <textarea  rows="5" class="form-control mt-2" name="meta_description" id="meta-description-ckeditors">
                                                    {{ $meta_description }}
                                                    </textarea>
                                            </div>
                                        </div>

                                                {{-- Custom CSS  --}}
                                        <div class="row">
                                            
                                            <div class="container"> 
                                                <label class="m-0"> Custom CSS 
                                                    <a class="iq-bg-warning" data-toggle="tooltip" data-placement="top" title="Please add custom css as <style> ..... </style>" data-original-title="Please enter the URL Slug" href="#">
                                                        <i class="las la-exclamation-circle"></i>
                                                    </a>:
                                                </label>

                                                <div class="col-md-12 p-0  align-items-center"> 
                                                    <textarea  rows="7" name="custom_css" class="form-control mt-2"  placeholder="Custom CSS" value="{{ $custom_css }}" > {{ $custom_css }}</textarea>
                                                </div> 
                                            </div> 
                                        </div>

                                                 {{-- Custom Bootstrap Link  --}}
                                        <br>
                                        <div class="row">
                                            
                                            <div class="container"> 
                                                <label class="m-0"> Bootstrap & Script Link
                                                    <a class="iq-bg-warning" data-toggle="tooltip" data-placement="top" title="Please add Bootstrap or Script Link as <link> ..... </link> or <script> .... </script>"  href="#">
                                                        <i class="las la-exclamation-circle"></i>
                                                    </a>:
                                                </label>

                                                <div class="col-md-12 p-0  align-items-center"> 
                                                    <textarea  rows="7" name="bootstrap_link" class="form-control mt-2"  placeholder="Bootstrap Link" value="{{ $bootstrap_link }}" > {{ $bootstrap_link }}</textarea>
                                                </div> 
                                            </div> 
                                        </div>

                                                 {{-- Custom Script Content --}}
                                        <br>
                                        <div class="row">
                                            <div class="container"> 
                                                <label class="m-0"> Custom JavaScript Content
                                                    <a class="iq-bg-warning" data-toggle="tooltip" data-placement="top" title="Please add Script Content Script as <Script> ..... </Script>"  href="#">
                                                        <i class="las la-exclamation-circle"></i>
                                                    </a>:
                                                </label>

                                                <div class="col-md-12 p-0  align-items-center"> 
                                                    <textarea  rows="7" name="script_content" class="form-control mt-2"  placeholder="Script Content" value="{{ $stript_content }}" > {{ $stript_content }}</textarea>
                                                </div> 
                                            </div> 
                                        </div>

                                                {{-- Header & Footer --}}

                                        <div class="row d-flex">
                                            <div class="container"> 
                                                <label class="m-0"> Header & Footer
                                                    <a class="iq-bg-warning" data-toggle="tooltip" data-placement="top" title="Enable/Disable - Header&Footer"  href="#">
                                                        <i class="las la-exclamation-circle"></i>
                                                    </a>:
                                                </label>

                                                <div class="col-sm-4">
                                                    <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                                        <div><label class="mt-1"> Header </label></div>
                                                        <div class="mt-1 d-flex align-items-center justify-content-around">
                                                            <div class="mr-2" style="color:red;">Disable</div>
                                                            <label class="switch mt-2">
                                                                <input name="header" type="checkbox" {{ (!empty($header) && $header == 1) ? "checked" : null }} >
                                                                <span class="slider round"></span>
                                                            </label>
                                                            <div class="ml-2" style="color:green;" >Enable</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                                        <div><label class="mt-1"> Footer </label></div>
                                                        <div class="mt-1 d-flex align-items-center justify-content-around">
                                                            <div class="mr-2" style="color:red;">Disable</div>
                                                            <label class="switch mt-2">
                                                                <input name="footer" type="checkbox" {{ (!empty($footer) && $footer == 1) ? "checked" : null }} >
                                                                <span class="slider round"></span>
                                                            </label>
                                                            <div class="ml-2" style="color:green;" >Enable</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div> 
                                        </div>

                                            {{-- Section 1 --}}

                                        <div class="row">
                                            <div class="col-sm-4">
                                                <input type="checkbox" id="sections_1" class="date" name="date[]" value="section_1" @if(!empty($section_1['0'])) checked @endif/>
                                                <label for="">Section 1</label>
                                                <span id="" class="section_1 ">
                                                    <i class="fa-solid fa-plus"></i>
                                                </span>
                                            </div>

                                            @forelse ($section_1 as $sections_1)
                                                <table class="table col-md-12" id=""> 
                                                    <tr>
                                                        <td>
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-md-12 p-0 align-items-center">
                                                                        <textarea  rows="5" class="form-control mt-2 summary-ckeditor" name="section_1[]"  >
                                                                            @if(!empty($sections_1->content)){{ ( $sections_1->content  ) }}@endif
                                                                        </textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><i class="fa-solid fa-trash-can remove-tr"> </i></td>
                                                    </tr>
                                                </table>
                                            @empty

                                            @endforelse

                                            <table class="table col-md-12" id="section_1"> </table>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-4">
                                                <input type="checkbox" id="sections_2" class="date" name="date[]" value="section_2" @if(!empty($section_2['0'])) checked @endif />
                                                <label for=""> Section 2 </label>
                                                <span id="" class="Section_2 ">
                                                    <i class="fa-solid fa-plus"></i>
                                                </span>
                                            </div>

                                            @forelse ($section_2 as $sections_2)
                                                <table class="table col-md-12" id=""> 
                                                    <tr>
                                                        <td>
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-md-12 p-0  align-items-center">
                                                                        <textarea  rows="5" class="form-control mt-2 summary-ckeditor" name="section_2[]" >
                                                                            @if(!empty($sections_2->content)){{ ( $sections_2->content  ) }}@endif
                                                                        </textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><i class="fa-solid fa-trash-can remove-tr"> </i></td>
                                                    </tr>
                                                </table>
                                            @empty
                                                
                                            @endforelse

                                            <table class="table col-md-12" id="Section_2"> </table>
                                        </div>
                        
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <input type="checkbox" class="date" id="sections_3" name="date[]" value="section_3" @if(!empty($section_3['0'])) checked @endif />
                                                <label for=""> Section 3 </label>
                                                <span  class="Section_3">
                                                    <i class="fa-solid fa-plus"></i>
                                                </span>
                                            </div>

                                            @forelse ($section_3 as $sections_3)
                                                <table class="table col-md-12" id=""> 
                                                    <tr>
                                                        <td>
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-md-12 p-0 align-items-center">
                                                                        <textarea  rows="5" class="form-control mt-2 summary-ckeditor" name="section_3[]" >
                                                                            @if(!empty($sections_3->content)){{ ( $sections_3->content  ) }}@endif
                                                                        </textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><i class="fa-solid fa-trash-can remove-tr"> </i></td>
                                                    </tr>
                                                </table>
                                            @empty
                                            @endforelse

                                            <table class="table col-md-12" id="Section_3"> </table>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <input type="checkbox" class="date" id="sections_4" name="date[]" value="section_4" @if(!empty($section_4['0'])) checked @endif />
                                                <label for=""> Section 4 </label>
                                                <span  class="Section_4">
                                                    <i class="fa-solid fa-plus"></i>
                                                </span>
                                            </div>

                                            @forelse ($section_4 as $sections_4)
                                                <table class="table col-md-12" id="Section_4"> 
                                                    <tr>
                                                        <td>
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-md-12 p-0  align-items-center">
                                                                        <textarea  rows="5" class="form-control mt-2 summary-ckeditor" name="section_4[]"  >
                                                                            @if(!empty($sections_4->content)){{ ( $sections_4->content  ) }}@endif
                                                                        </textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><i class="fa-solid fa-trash-can remove-tr"> </i></td>
                                                    </tr>
                                                </table>
                                            @empty
                                            @endforelse

                                            <table class="table col-md-12" id="Section_4"> </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value={{ $landing_page_id }} name="landing_page_id" >
                            <input type="submit" class="btn btn-primary action-button" id="" value="Save" />
                        </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
        var i = 0;

        $(".section_1").click(function(){
                ++i;
                $('#sections_1').prop('checked', true);
                $("#section_1").append('<tr> <td> <div class="container"> <div class="row"> <div class="col-md-12 p-0  align-items-center"> <textarea  rows="5" name="section_1[]" class="form-control mt-2" id= '+ 'ck_editor_section1-' + i  +' placeholder="" > </textarea> </div> </div> </div> </td>  <td> <i class="fa-solid fa-trash-can remove-tr"> </i> </td> </tr>');
                CKEDITOR.replace('ck_editor_section1-'+ i, {
                    filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                    filebrowserUploadMethod: 'form'

                });
            });

        $(".Section_2").click(function(){
                ++i;
                $('#sections_2').prop('checked', true);
                $("#Section_2").append('<tr> <td> <div class="container"> <div class="row"> <div class="col-md-12 p-0  align-items-center"> <textarea  rows="5" name="section_2[]" class="form-control mt-2" id= '+ 'ck_editor_section2-' + i  +' /> </textarea> </div> </div> </div> </td>  <td> <i class="fa-solid fa-trash-can remove-tr"> </i> </td>   </tr>');
                CKEDITOR.replace('ck_editor_section2-'+ i, {
                    filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                    filebrowserUploadMethod: 'form'

                });
            });

       $(".Section_3").click(function(){
           ++i;
           $('#sections_3').prop('checked', true);
           $("#Section_3").append('<tr> <td> <div class="container"> <div class="row"> <div class="col-md-12 p-0  align-items-center"> <textarea  rows="5" name="section_3[]" class="form-control mt-2" id= '+ 'ck_editor_section3-' + i  +' /> </textarea> </div> </div> </div> </td>  <td> <i class="fa-solid fa-trash-can remove-tr"> </i> </td>   </tr>');
            CKEDITOR.replace('ck_editor_section3-'+ i, {
                filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form'

            });
        });

       $(".Section_4").click(function(){
           ++i;
           $('#sections_4').prop('checked', true);
           $("#Section_4").append('<tr> <td> <div class="container"> <div class="row"> <div class="col-md-12 p-0  align-items-center"> <textarea  rows="5" name="section_4[]" class="form-control mt-2" id= '+ 'ck_editor_section4-' + i  +' /> </textarea> </div> </div> </div> </td>  <td> <i class="fa-solid fa-trash-can remove-tr"> </i> </td>   </tr>');
            CKEDITOR.replace('ck_editor_section4-'+ i, {
                filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form'

            });
        });

      
       $(document).on('click', '.remove-tr', function(){

            if( $(this).closest('tr').is('tr:only-child') ) {

                $(this).closest('tr').remove();
            }
            else {
                $(this).closest('tr').remove();
            }

       }); 
     
       CKEDITOR.replaceAll( 'summary-ckeditor', {
                toolbar : 'simple'
        });

</script>










