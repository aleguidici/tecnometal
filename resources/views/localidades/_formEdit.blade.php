@csrf

<div class="box box-info">
    <div class="box-header with-border">
        <h1 class="box-title">Tecnometal - Editar Localidad</h1>
    </div>
    <div class="box-body">
        <div class="text-info">(*) Campos obligatorios</div>
        <br>

        <div class="row">
            <div class="col-md-12">
                <label> Nombre Localidad* <br></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-map-o" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" name="name" placeholder="Ingrese Nombre" value="{{ old('name', $localidad->name) }}">
                </div>
                {!! $errors->first('name', '<small style = "color:#ff0000">:message</small><br>') !!}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4">
                <label> País* <br></label>
                <select class="selectpicker" data-show-subtext="true" data-live-search="true" name="pais_id" id="pais_select_picker" required="required" data-width="100%" title="Seleccione un pais">
                    @foreach ($paises as $pais)
                            <option value="{{$pais->id}}" @if ($localidad->provincia->pais->id == $pais->id) selected @endif>{{$pais->name}}</option>
                        @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label>Provincia / Estado* <br></label>
                <select class="selectpicker" data-show-subtext="true" data-live-search="true" name="provincia_id" id="prov_select_picker" required="required" title="Seleccione una provincia" data-width="100%">
                    @foreach ($provincias as $provincia)
                            <option value="{{$provincia->id}}" @if ($localidad->provincia->id == $provincia->id) selected @endif>{{$provincia->name}}</option>
                        @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label> Código Postal* <br></label>
                <input type="text" class="form-control" name="codigo_postal" placeholder="Ingrese Código Postal" value="{{ old('codigo_postal',$localidad->codigo_postal) }}">
                {!! $errors->first('codigo_postal', '<small style = "color:#ff0000">:message</small><br>') !!}
            </div>
        </div>
        <br>
        <button class="btn btn-success pull-right"><b>Actualizar Localidad<b></button>
        <a href="{{route('localidades.index')}}" class="btn btn-danger"><b>Cancelar</b></a>
    </div>
</div>
