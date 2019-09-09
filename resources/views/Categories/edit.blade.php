@extends('Layouts.master')

@section('title')
    <title>Management Category</title>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-8">
                        <h1>Management Category</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="right">
            <button type="button" class="btn" data-toggle="modal" data-target="#exampleModal"><i class="fa-plus-square"></i></button>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @if(session('success'))
                            <div class="alert alert-success" role="alert">
                                {{session('success')}}
                            </div>
                        @endif

                        @if (count($errors) > 0)
                            <div class="alert alert-danger alert-dismissable" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <ul>
                                @foreach ($errors->all() as $error)
                                    <li>
                                        {{ $error }}
                                    </li>
                                @endforeach            
                                </ul>
                            </div> 
                        @endif
                    <div class="modal-body">
                        <form action="{{ route('category.update', $categories->id) }}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}

                        <input type="hidden" name="_method" value="PUT">
                            <div class="form-group">
                                <label for="category">Category</label>
                                <input name="category" type="text" class="form-control" id="category" aria-describedby="emailHelp" placeholder="Enter Category" value="{{$categories->category}}">
                            </div>

                            <div class="form-group">
                                <label for="descriprion">Description</label>
                                <textarea name="description" class="form-control" id="description" rows="3">{{$categories->description}}</textarea>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <a href="/category" class="btn btn-secondary">Close</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
                @slot('footer')

                @endslot
                    </div>
                </div>
        </section>
    </div>
@endsection