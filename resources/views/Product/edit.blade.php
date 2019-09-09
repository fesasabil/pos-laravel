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
                        <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}

                        <input type="hidden" name="_method" value="PUT">
                            <div class="form-group">
                                <label for="code">Code</label>
                                <input name="code" type="text" class="form-control" id="code" aria-describedby="emailHelp" placeholder="Enter Code" value="{{$product->code}}">
                            </div>

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input name="name" type="text" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter Name" value="{{$product->name}}">
                            </div>

                            <div class="form-group">
                                <label for="descriprion">Description</label>
                                <textarea name="description" class="form-control" id="description" rows="3">{{$product->description}}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="stock">Stock</label>
                                <input name="stock" type="text" class="form-control" id="stock" aria-describedby="emailHelp" placeholder="Enter Stock" value="{{$product->stock}}">
                            </div>

                            <div class="form-group">
                                <label for="price">Price</label>
                                <input name="price" type="text" class="form-control" id="price" aria-describedby="emailHelp" placeholder="Enter Price" value="{{$product->price}}">
                            </div>

                            <div class="form-group">
                                <label for="photo">Photo</label>
                                <input type="file" name="photo" class="form-control" value="{{ old('photo')}}">
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