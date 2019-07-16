@extends('layout.bmaster')

@section('isi')

    
   
                <div class="span9">
                    <div class="content">

                        <div class="module">
                            <div class="module-head">
                                <h3>Forms</h3>
                            </div>
                            <div class="module-body">

                                    
                                    <br />

                                    <form class="form-horizontal row-fluid" action="{{ route('up_slider') }}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}

                                        <div class="control-group">
                                            <label class="control-label" for="basicinput">Basic Input</label>
                                            <div class="controls">
                                                <input type="text" name="judul" id="basicinput" placeholder="Type something here..." class="span8">
                                                <span class="help-inline">Minimum 5 Characters</span>
                                            </div>
                                        </div>

                            
                                        <div class="control-group">
                                            <label class="control-label" for="basicinput">Textarea</label>
                                            <div class="controls">
                                                <textarea class="span8" name="keterangan" rows="5"></textarea>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="basicinput">File Gambar</label>
                                            <div class="controls">
                                                <input type="file" name="file" id="basicinput" placeholder="Type something here..." class="span8">
                                                <span class="help-inline">Jpeg | jpg | png</span>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <div class="controls">
                                                <button type="submit" class="btn">Submit Form</button>
                                            </div>
                                        </div>
                                    </form>
                            </div>
                        </div>

                        
                        
                    </div><!--/.content-->
                </div><!--/.span9-->

@endsection