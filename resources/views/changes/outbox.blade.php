@extends('layouts.master')

@section('page-title',"學校交換寄件匣 | 彰化縣學校文件交換系統")

@section('content')
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('bootstrap4c-chosen/css/component-buttons.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap4c-chosen/css/component-chosen.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap4c-chosen/css/component-custom-switch.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap4c-chosen/css/component-dropzone.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap4c-chosen/css/component-forms.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap4c-chosen/css/component-tageditor.css') }}" rel="stylesheet">
    <h1>學校交換寄件匣</h1>
    <div class="card card-outline-secondary my-4">
        <div class="card-header">
            寄件資料
        </div>
        <div class="card-body">
            <table class="table table-light">
                <thead>
                <th width="300">
                    收件者<i class="text-danger">★</i>：
                </th>
                <th colspan="2">
                    說明<i class="text-danger">★</i>：
                </th>
                </thead>
                <tbody>
                {{ Form::open(['route'=>'outbox_store','files'=>true,'method'=>'post','id'=>'store','onsubmit'=>'return false;']) }}
                <tr>
                    <td>

                            <select name="for" id="single" class="form-control form-control-chosen" data-placeholder="Please select...">
                                <option></option>
                                @foreach($user_menu as $k=>$v)
                                <option value="{{ $k }}">{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>

                        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
                        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
                        <script src="{{ asset('bootstrap4c-chosen/js/chosen.jquery.js') }}"></script>
                        <script src="{{ asset('bootstrap4c-chosen/js/dropzone.js') }}"></script>
                        <script src="{{ asset('bootstrap4c-chosen/js/jquery.tag-editor.js') }}"></script>
                        <script src="{{ asset('bootstrap4c-chosen/js/jquery.caret.js') }}"></script>
                    </td>
                    <td>
                        {{ Form::text('title',null,['id'=>'title','class' => 'form-control', 'placeholder' => '檔案說明','required'=>'required']) }}
                    </td>
                    <td>

                    </td>
                </tr>
                </tbody>
                <thead>
                <th width="200">
                    確認收件者
                </th>
                <th colspan="2">
                    附檔<i class="text-danger">★</i>：( < 5MB )
                </th>
                </thead>
                <tbody>
                <tr>
                    <td nowrap>
                        <h3 class="text-danger" id="school"></h3>
                    </td>
                    <td>
                        <input type="file" name="file" class="form-control" required="required">
                    </td>
                    <td>
                        <a href="#" class="btn btn-success" onclick="bbconfirm3('store','確定寄出？')">寄出</a>
                    </td>
                </tr>
                {{ Form::close() }}
                </tbody>
            </table>
        </div>
    </div>
    <div class="card card-outline-secondary my-4">
        <div class="card-header">
            寄件記錄 ( 檔案僅保留三個月 )
        </div>
        <div class="card-body">
            <table class="table table-light">
                <thead>
                <tr>
                    <th width="180">
                        寄件時間
                    </th>
                    <th width="120">
                        收件人
                    </th>
                    <th>
                        說明
                    </th>
                    <th>
                        狀態
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($changes as $change)
                    <tr>
                        <td nowrap>
                            {{ $change->created_at }}
                        </td>
                        <td nowrap>
                            <?php
                            $user = \App\User::where('id','=',$change->for)->first();
                            ?>
                            {{ $user->name }}
                        </td>
                        <td>
                            {{ $change->title }}
                        </td>
                        <td nowrap>
                            <?php
                            if($change->download == 1){
                                $d = $change->updated_at."已下載";
                            }else{
                                $d = "未曾下載";
                            }
                            ?>
                            {{ $d }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function change() {
            var x=document.getElementById('for');
            document.getElementById('school').innerText = '給 '+ x.options[x.selectedIndex].text;
        }
    </script>
    <script type="text/javascript">
        $('.form-control-chosen').chosen({
            allow_single_deselect: true,
            search_contains: true,
        });
        $('.form-control-chosen-required').chosen({
            allow_single_deselect: false
        });
        $('.form-control-chosen-optgroup').chosen();
        // Clickable optgroup add class
        $(function() {
            $('[title="clickable_optgroup"]').addClass('chosen-container-optgroup-clickable');
        });
        // Clickable optgroup
        $(document).on('click', '[title="clickable_optgroup"] .group-result', function() {
            var unselected = $(this).nextUntil('.group-result').not('.result-selected');
            if(unselected.length) {
                unselected.trigger('mouseup');
            } else {
                $(this).nextUntil('.group-result').each(function() {
                    $('a.search-choice-close[data-option-array-index="' + $(this).data('option-array-index') + '"]').trigger('click');
                });
            }
        });
    </script>
    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        jQuery(document).ready(function() {
            $("#dropzone").dropzone({
                url: "/file/post",
                dictDefaultMessage: "Drop files here or<br>click to upload..."
            });
        });
    </script>
    <script type="text/javascript">
        $('.form-control-tag').tagEditor({
            initialTags: ['Hello', 'World'],
            delimiter: ', ',
            forceLowercase: false,
            animateDelete: 0,
            placeholder: 'Enter tag...'
        });
        // Removing all tags
        $(document).on('click', '.btn-remove-tags', function() {
            $('.form-control-tag').next('.tag-editor').find('.tag-editor-delete').click();
        });
    </script>
    <script type="text/javascript">
        $('body').on('input propertychange', '.form-group-floating-label', function(e) {
            $(this).toggleClass('form-group-floating-label-with-value', !!$(e.target).val());
        }).on('focus', '.form-group-floating-label', function() {
            $(this).addClass('form-group-floating-label-with-focus');
        }).on('blur', '.form-group-floating-label', function() {
            $(this).removeClass('form-group-floating-label-with-focus');
        });
        $('.form-group-floating-label .form-control').focusout(function () {
            var text_val = $(this).val();
            $(this).parent().toggleClass('form-group-floating-label-with-value', text_val !== "");
        }).focusout();
    </script>
    <script type="text/javascript">
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-27560722-2', 'auto');
        ga('send', 'pageview');
    </script>
@endsection
