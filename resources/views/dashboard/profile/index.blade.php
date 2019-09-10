@extends('layouts.myapp')

@section('content')

<div class="content">
    <div class="page-inner">
        <h4 class="page-title">Meu Perfil</h4>
        <div class="row">
            <div class="col-md-8">
                <div class="card card-with-nav">
                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Nome</label>
                                        <input type="text" class="form-control" name="name" placeholder="Name" value="{{ $item->name }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Email</label>
                                        <input disabled type="email" class="form-control" name="email" placeholder="Name" value="{{ $item->email }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="form-group form-group-default">
                                        <label>Imagem</label>
                                        <input type="file" class="form-control" name="image">
                                    </div> 
                                </div>
                            </div>
                            <div class="text-right mt-3 mb-3">
                                <button class="btn btn-success">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-profile">
                    <div class="card-header" style="background-image: url('{{'public/img/blogpost.jpg'}}')">
                        <div class="profile-picture">
                            <div class="avatar avatar-xl">
                                <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('img/profile.jpg') }}" alt="..." class="avatar-img rounded-circle">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="user-profile text-center">
                            <div class="name">{{ $item->name }}</div>
                            <div class="job">{{ $item->email }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection