<!--Modal create indicator -->

<div class="modal fade" id="addIndicatorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Agregar Indicador</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" method="POST" id="add_indicator">
      @csrf
      <div class="modal-body p-4 bg-light">
        <ul id="saveForm_errList"></ul>
        <div class="row">
          <div class="col-lg">
            <label for="nombre">Nombre Indicador</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
            <span class="text-danger error-text name_error"></span>
          </div>
          <div class="col-lg">
            <label for="codigo">Codigo</label>
            <input type="text" name="codigo" id="codigo" class="form-control" required>
            <span class="text-danger error-text codigo_error"></span>
          </div>
        </div>
        <div class="row">
            <div class="col-lg">
              <label for="unidadMedida">Unidad de medida</label>
              <input type="text" name="unidadMedida" id="unidadMedida" class="form-control" required>
              <span class="text-danger error-text unidadMedida_error"></span>
            </div>
            <div class="col-lg">
              <label for="valor">Valor</label>
              <input type="text" name="valor" id="valor" class="form-control" required>
              <span class="text-danger error-text valor_error"></span>
            </div>
        </div>

        <div class="row">
            <div class="col-lg">
              <label for="fecha">Fecha</label>
              <input type="date"  name="fecha" id="fecha" class="form-control" required>
              <span class="text-danger error-text fecha_error"></span>
            </div>
            <div class="col-lg">
              <label for="tiempo">Tiempo</label>
              <input type="text" name="tiempo" id="tiempo" class="form-control">
              <span class="text-danger error-text tiempo_error"></span>
            </div>
        </div>
        <div class="my-2">
            <label for="origen">Origen</label>
            <input type="text" name="origen" id="origen" class="form-control" required>
            <span class="text-danger error-text origen_error"></span>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" id="add_indicator_btn" class="btn btn-primary">Agregar</button>
      </div>
    </form>
    </div>
  </div>
</div>


<!--Modal update indicator -->

<div class="modal fade" id="editIndicatorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Actualizar Indicador</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="POST" id="edit_indicator">
        @csrf
        <input type="hidden" name="indicator_id" id="indicator_id">

        <div class="modal-body p-4 bg-light">
            <ul id="updateForm_errList"></ul>
          <div class="row">
            <div class="col-lg">
              <label for="edit_nombre">Nombre Indicador</label>
              <input type="text" name="edit_nombre" id="edit_nombre" class="form-control" required>
            </div>
            <div class="col-lg">
              <label for="edit_codigo">Codigo</label>
              <input type="text" name="edit_codigo" id="edit_codigo" class="form-control" required>
            </div>
          </div>
          <div class="row">
              <div class="col-lg">
                <label for="edit_unidadMedida">Unidad de medida</label>
                <input type="text" name="edit_unidadMedida" id="edit_unidadMedida" class="form-control" required>
              </div>
              <div class="col-lg">
                <label for="edit_valor">Valor</label>
                <input type="text" name="edit_valor" id="edit_valor" class="form-control" required>
              </div>
          </div>

          <div class="row">
              <div class="col-lg">
                <label for="edit_fecha">Fecha</label>
                <input type="date"  name="edit_fecha" id="edit_fecha" class="form-control" required>
              </div>
              <div class="col-lg">
                <label for="edit_tiempo">Tiempo</label>
                <input type="text" name="edit_tiempo" id="edit_tiempo" class="form-control" required>
              </div>
          </div>
          <div class="my-2">
              <label for="edit_origen">Origen</label>
              <input type="text" name="edit_origen" id="edit_origen" class="form-control" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" id="update_indicator_btn" class="btn btn-primary">Actualizar</button>
        </div>
      </form>
      </div>
    </div>
  </div>
