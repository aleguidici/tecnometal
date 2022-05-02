@csrf

<div class="box box-info">
    <div class="box-header with-border">
        <h1 class="box-title">Tecnometal - Nueva Localidad</h1>
    </div>
    <div class="box-body">
        <div class="text-info">(*) Campos obligatorios</div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <label> Nombre Localidad* <br></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-map-o" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" name="name" placeholder="Ingrese Nombre" value="{{ old('name') }}">
                </div>
                {!! $errors->first('name', '<small style = "color:#ff0000">:message</small><br>') !!}
            </div>
        </div>
        <br>
        
        <div class="row">
            <div class="col-md-4">
                <label> País* <br></label>
                <select class="selectpicker" data-show-subtext="true" data-live-search="true" name="pais_id" id="pais_select_picker" required="required" data-width="100%" title="Seleccione un país">
                    @foreach ($paises as $pais)
                            <option value="{{$pais->id}}">
                                {{$pais->name}}
                            </option>
                        @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label>Provincia / Estado* <br></label>
                <select class="selectpicker" data-show-subtext="true" title="Seleccione una provincia" data-live-search="true" disabled name="provincia_id" id="prov_select_picker" required="required" data-width="100%" disabled> </select>
            </div>
            <div class="col-md-3">
                <label> Código Postal* <br></label>
                <input type="text" class="form-control" name="codigo_postal" placeholder="Ingrese Código Postal" value="{{ old('codigo_postal') }}">
                {!! $errors->first('codigo_postal', '<small style = "color:#ff0000">:message</small><br>') !!}
            </div>
        </div>
        <br>

        <br>
        <button class="btn btn-success pull-right"><b>Crear Localidad</b></button>
        <a href="{{route('localidades.index')}}" class="btn btn-danger"><b>Cancelar</b></a>
    </div>
</div>
