@extends('layouts.app')
@section('title')
    New Notice
@endsection
@section('content')
    <table role="presentation" class="main">
        <tr>
            <td class="wrapper">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <p>Hi there,</p>
                            <p>
                                {!! $template->content !!}
                            </p>
                            <span class="apple-link">Please do not reply directly to this system-generated email.</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@stop
