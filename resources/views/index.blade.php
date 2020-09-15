@extends('templates.template')

@section('content')
@php
  $edit = isset($product);
@endphp
  <h1 class="text-center mt-3 mb-3">{{$edit ? 'Editar Produto' : 'Cadastro de Produtos'}}</h1>
  @if(isset($errors) && count($errors) > 0)
    <div class="text-center mt-4 mb-4 p-2 alert alert-danger">
      @foreach($errors->all() as $error)
        <p>{{$error}}</p>
      @endforeach
    </div>
  @endif
  <div class="col-8 m-auto">
  @php
    $url = $edit ? "products/$product->id" : 'products'
  @endphp
    <form name="formCadastro" method="post" action="{{url($url)}}" id="formCadastro">
      @csrf
      <label for="product">Produto</label>
      <input type="text" class="form-control" name="product" placeholder="Ex: Arroz Branco" value="{{$edit ? $product->name : ''}}" required>
      <label for="location">Localização</label>
      <select name="location" class="form-control" id="location">
        <option value="{{$edit ? $product->relLocation->id : NULL}}">
          {{$edit ? $product->relLocation->aisle.$product->relLocation->shelf.$product->relLocation->side : 'Corredor/Prateleira/Lado'}}
        </option>
        @foreach($locations as $location)
          <option value="{{$location->id}}">{{$location->aisle}}{{$location->shelf}}{{$location->side}}</option>
        @endforeach
      </select>
      <a href="{{url('locations')}}">
        <button class="btn btn-sm btn-dark mt-2 mb-3" type="button">GERENCIAR LOCALIZAÇÕES</button>
      </a>
      <br>
      <label for="description">Descrição</label>
      <input type="text" class="form-control" name="description" placeholder="Ex: Arroz tipo 1 parbolizado 1Kg" value="{{$edit ? $product->description : ''}}" required>
      <label for="price">Preço</label>
      <input type="text" class="form-control" name="price" placeholder="Ex: 12.90" value="{{$edit ? $product->price : ''}}" required>
      <div class="col-8 m-auto text-center">
        @if($edit)
        <a href="/products">
          <button type="button" class="btn btn-dark">VOLTAR</button>
        </a>
        @endif
        <input type="submit" class="btn btn-success mt-5 mb-5" value="{{$edit ? 'SALVAR' : 'ADICIONAR'}}">
      </div>
    </form>
  </div>
  @if(!$edit)
  <div class="col-8 m-auto">
    <table class="table table-hover table-sm">
      <thead>
        <tr>
          <th scope="col">Produto</th>
          <th scope="col">Localização</th>
          <th scope="col">Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach($products as $product)
          <tr>
            <td scope="col">{{$product->name}}</td>
            @php
              $location = $product->find($product->id)->relLocation
            @endphp
            <td scope="col">{{$location->aisle}}{{$location->shelf}}{{$location->side}}</td>
            <td scope="col">
              <a href="{{url("products/$product->id/edit")}}">
                <button class="btn btn-sm btn-primary pl-3 pr-3">Editar</button>
              </a>
              <a href="{{url("products/$product->id")}}" class="js-del">
                <button class="btn btn-sm btn-danger">Remover</button>
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif
@endsection