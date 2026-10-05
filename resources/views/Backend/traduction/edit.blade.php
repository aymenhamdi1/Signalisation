@extends('template.admin_master')
@section('Content')
<script src="{{ asset('Backend/assets/js/jquery.min.js')}}"></script>
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('DBR') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Add') }} {{ __('Translation') }}</li>
                </ol>
            </div>
            <h4 class="page-title">{{ __('Add') }} {{ __('Translation') }}</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('traduction.update',$traductions[0]->key) }}">
                    
                    @csrf
                    <div class="add_item">
                        @foreach($traductions as $edit)
                        <div class="delete_whole_extra_item_add" id="delete_whole_extra_item_add">
                            <div class="row mb-12">
                                <div class="col-sm-1 form-group">
                                    <label>{{ __('Language') }}</label>
                                    <input name="language[]" class="form-control" id="language" value="{{ $edit->language }}" placeholder="{{ __('ar, fr, en') }}">
                                    @error('language')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-5 form-group">
                                    <label>{{ __('The word in English') }}</label>
                                    <input name="key[]" class="form-control" id="key" value="{{ $edit->key }}" placeholder="{{ __('The word in English') }}">
                                    @error('key')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-5 form-group">
                                    <label>{{ __('The word is translated into the desired language') }}</label>
                                    <input name="value[]" class="form-control" id="value" value="{{ $edit->value }}" placeholder="{{ __('The word is translated into the desired language') }}">
                                    @error('value')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-1" style="padding-top: 25px;">
                                    <span class="btn btn-success addeventmore"><i class="mdi mdi-plus-circle"></i> </span>
                                    <span class="btn btn-danger removeeventmore"><i class="mdi mdi-minus-circle"></i> </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <br>
                    <!-- end row -->
                    <br>
                    <button type="submit" class="btn btn-info float-end">{{ __('Save') }}</button>
                </form>
            </div>
        </div>
    </div> <!-- end col -->
</div>
<div style="visibility: hidden;">
    <div class="whole_extra_item_add" id="whole_extra_item_add">
        <div class="delete_whole_extra_item_add" id="delete_whole_extra_item_add">
            <div class="add_item">
                <div class="row mb-12">
                    <div class="col-sm-1 form-group">
                        <label>{{ __('Language') }}</label>
                        <input name="language[]" class="form-control" id="language" placeholder="{{ __('ar, fr, en') }}">
                        @error('language')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-5 form-group">
                        <label>{{ __('The word in English') }}</label>
                        <input name="key[]" class="form-control" id="key" placeholder="{{ __('The word in English') }}">
                        @error('key')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-5 form-group">
                        <label>{{ __('The word is translated into the desired language') }}</label>
                        <input name="value[]" class="form-control" id="value" placeholder="{{ __('The word is translated into the desired language') }}">
                        @error('value')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-1" style="padding-top: 25px;">
                        <span class="btn btn-success addeventmore"><i class="mdi mdi-plus-circle"></i> </span>
                        <span class="btn btn-danger removeeventmore"><i class="mdi mdi-minus-circle"></i> </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var counter = 0;
        var languages = ["fr", "ar"]; // Tableau des langues disponibles
        var currentLanguageIndex = 0; // Index de la langue actuelle
    
        $(document).on("click", ".addeventmore", function() {
            var whole_extra_item_add = $('#whole_extra_item_add').html();
            var language = languages[currentLanguageIndex]; // Récupère la langue actuelle
            var key = $(this).closest(".add_item").find("input[name='key[]']").val();
            var newLine = $(whole_extra_item_add).find(".add_item");
            newLine.find("input[name='language[]']").val(language);
            newLine.find("input[name='key[]']").val(key);
            $(this).closest(".add_item").append(newLine);
    
            // Change la langue actuelle pour la prochaine ligne
            currentLanguageIndex = (currentLanguageIndex + 1) % languages.length;
            counter++;
        });
    
        $(document).on("click", '.removeeventmore', function(event) {
            $(this).closest(".add_item").remove();
            counter -= 1;
        });
    });
    </script>
    

@endsection
