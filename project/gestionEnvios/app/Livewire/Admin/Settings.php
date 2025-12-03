<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\EstadoEnvio;
use App\Models\Tarifa;
use App\Models\TipoVehiculo;
use App\Models\TipoEnvio;
use Illuminate\Support\Str;

class Settings extends Component
{
    public $activeTab = 'estados';

    // Estados de Envío
    public $showEstadoModal = false;
    public $showEstadoDeleteModal = false;
    public $editEstadoMode = false;
    public $estadoId;
    public $estadoNombre;
    public $estadoSlug;
    public $estadoEsFinal = false;

    // Tarifas
    public $showTarifaModal = false;
    public $showTarifaDeleteModal = false;
    public $editTarifaMode = false;
    public $tarifaId;
    public $tarifaConcepto;
    public $tarifaValor;
    public $tarifaTipo = 'fijo';
    public $tarifaDescripcion;
    public $tarifaActivo = true;

    // Tipos de Vehículos
    public $showTipoVehiculoModal = false;
    public $showTipoVehiculoDeleteModal = false;
    public $editTipoVehiculoMode = false;
    public $tipoVehiculoId;
    public $tipoVehiculoNombre;
    public $tipoVehiculoCapacidadKg;
    public $tipoVehiculoCapacidadM3;
    public $tipoVehiculoDescripcion;
    public $tipoVehiculoActivo = true;

    // Tipos de Envío
    public $showTipoEnvioModal = false;
    public $showTipoEnvioDeleteModal = false;
    public $editTipoEnvioMode = false;
    public $tipoEnvioId;
    public $tipoEnvioNombre;
    public $tipoEnvioPrioridad;
    public $tipoEnvioTarifaBase;
    public $tipoEnvioTarifaPorKg;
    public $tipoEnvioTarifaPorM3;

    // ==================== ESTADOS DE ENVÍO ====================

    public function openCreateEstadoModal()
    {
        $this->resetEstadoForm();
        $this->editEstadoMode = false;
        $this->showEstadoModal = true;
    }

    public function openEditEstadoModal($estadoId)
    {
        $this->resetEstadoForm();
        $estado = EstadoEnvio::findOrFail($estadoId);

        $this->estadoId = $estado->id;
        $this->estadoNombre = $estado->nombre;
        $this->estadoSlug = $estado->slug;
        $this->estadoEsFinal = $estado->es_final;

        $this->editEstadoMode = true;
        $this->showEstadoModal = true;
    }

    public function closeEstadoModal()
    {
        $this->showEstadoModal = false;
        $this->resetEstadoForm();
        $this->resetValidation();
    }

    public function resetEstadoForm()
    {
        $this->estadoId = null;
        $this->estadoNombre = '';
        $this->estadoSlug = '';
        $this->estadoEsFinal = false;
    }

    public function saveEstado()
    {
        $this->validate([
            'estadoNombre' => 'required|string|max:255',
            'estadoSlug' => 'required|string|max:255|unique:estado_envios,slug,' . $this->estadoId,
        ], [
            'estadoNombre.required' => 'El nombre es obligatorio',
            'estadoSlug.required' => 'El slug es obligatorio',
            'estadoSlug.unique' => 'Este slug ya existe',
        ]);

        if ($this->editEstadoMode) {
            $estado = EstadoEnvio::findOrFail($this->estadoId);
            $estado->update([
                'nombre' => $this->estadoNombre,
                'slug' => $this->estadoSlug,
                'es_final' => $this->estadoEsFinal,
            ]);
            session()->flash('message', 'Estado actualizado exitosamente.');
        } else {
            EstadoEnvio::create([
                'nombre' => $this->estadoNombre,
                'slug' => $this->estadoSlug,
                'es_final' => $this->estadoEsFinal,
            ]);
            session()->flash('message', 'Estado creado exitosamente.');
        }

        $this->closeEstadoModal();
    }

    public function confirmDeleteEstado($estadoId)
    {
        $this->estadoId = $estadoId;
        $this->showEstadoDeleteModal = true;
    }

    public function deleteEstado()
    {
        $estado = EstadoEnvio::findOrFail($this->estadoId);
        $estado->delete();

        $this->showEstadoDeleteModal = false;
        $this->estadoId = null;
        session()->flash('message', 'Estado eliminado exitosamente.');
    }

    public function cancelDeleteEstado()
    {
        $this->showEstadoDeleteModal = false;
        $this->estadoId = null;
    }

    public function updatedEstadoNombre()
    {
        if (!$this->editEstadoMode) {
            $this->estadoSlug = Str::slug($this->estadoNombre);
        }
    }

    // ==================== TARIFAS ====================

    public function openCreateTarifaModal()
    {
        $this->resetTarifaForm();
        $this->editTarifaMode = false;
        $this->showTarifaModal = true;
    }

    public function openEditTarifaModal($tarifaId)
    {
        $this->resetTarifaForm();
        $tarifa = Tarifa::findOrFail($tarifaId);

        $this->tarifaId = $tarifa->id;
        $this->tarifaConcepto = $tarifa->concepto;
        $this->tarifaValor = $tarifa->valor;
        $this->tarifaTipo = $tarifa->tipo;
        $this->tarifaDescripcion = $tarifa->descripcion;
        $this->tarifaActivo = $tarifa->activo;

        $this->editTarifaMode = true;
        $this->showTarifaModal = true;
    }

    public function closeTarifaModal()
    {
        $this->showTarifaModal = false;
        $this->resetTarifaForm();
        $this->resetValidation();
    }

    public function resetTarifaForm()
    {
        $this->tarifaId = null;
        $this->tarifaConcepto = '';
        $this->tarifaValor = '';
        $this->tarifaTipo = 'fijo';
        $this->tarifaDescripcion = '';
        $this->tarifaActivo = true;
    }

    public function saveTarifa()
    {
        $this->validate([
            'tarifaConcepto' => 'required|string|max:255',
            'tarifaValor' => 'required|numeric|min:0',
            'tarifaTipo' => 'required|in:fijo,por_km,por_kg',
        ], [
            'tarifaConcepto.required' => 'El concepto es obligatorio',
            'tarifaValor.required' => 'El valor es obligatorio',
            'tarifaValor.numeric' => 'El valor debe ser numérico',
            'tarifaTipo.required' => 'El tipo es obligatorio',
        ]);

        if ($this->editTarifaMode) {
            $tarifa = Tarifa::findOrFail($this->tarifaId);
            $tarifa->update([
                'concepto' => $this->tarifaConcepto,
                'valor' => $this->tarifaValor,
                'tipo' => $this->tarifaTipo,
                'descripcion' => $this->tarifaDescripcion,
                'activo' => $this->tarifaActivo,
            ]);
            session()->flash('message', 'Tarifa actualizada exitosamente.');
        } else {
            Tarifa::create([
                'concepto' => $this->tarifaConcepto,
                'valor' => $this->tarifaValor,
                'tipo' => $this->tarifaTipo,
                'descripcion' => $this->tarifaDescripcion,
                'activo' => $this->tarifaActivo,
            ]);
            session()->flash('message', 'Tarifa creada exitosamente.');
        }

        $this->closeTarifaModal();
    }

    public function confirmDeleteTarifa($tarifaId)
    {
        $this->tarifaId = $tarifaId;
        $this->showTarifaDeleteModal = true;
    }

    public function deleteTarifa()
    {
        $tarifa = Tarifa::findOrFail($this->tarifaId);
        $tarifa->delete();

        $this->showTarifaDeleteModal = false;
        $this->tarifaId = null;
        session()->flash('message', 'Tarifa eliminada exitosamente.');
    }

    public function cancelDeleteTarifa()
    {
        $this->showTarifaDeleteModal = false;
        $this->tarifaId = null;
    }

    public function toggleTarifaActivo($tarifaId)
    {
        $tarifa = Tarifa::findOrFail($tarifaId);
        $tarifa->update(['activo' => !$tarifa->activo]);

        $status = $tarifa->activo ? 'activada' : 'desactivada';
        session()->flash('message', "Tarifa {$status} exitosamente.");
    }

    // ==================== TIPOS DE VEHÍCULOS ====================

    public function openCreateTipoVehiculoModal()
    {
        $this->resetTipoVehiculoForm();
        $this->editTipoVehiculoMode = false;
        $this->showTipoVehiculoModal = true;
    }

    public function openEditTipoVehiculoModal($tipoVehiculoId)
    {
        $this->resetTipoVehiculoForm();
        $tipoVehiculo = TipoVehiculo::findOrFail($tipoVehiculoId);

        $this->tipoVehiculoId = $tipoVehiculo->id;
        $this->tipoVehiculoNombre = $tipoVehiculo->nombre;
        $this->tipoVehiculoCapacidadKg = $tipoVehiculo->capacidad_max_kg;
        $this->tipoVehiculoCapacidadM3 = $tipoVehiculo->capacidad_max_m3;
        $this->tipoVehiculoDescripcion = $tipoVehiculo->descripcion;
        $this->tipoVehiculoActivo = $tipoVehiculo->activo;

        $this->editTipoVehiculoMode = true;
        $this->showTipoVehiculoModal = true;
    }

    public function closeTipoVehiculoModal()
    {
        $this->showTipoVehiculoModal = false;
        $this->resetTipoVehiculoForm();
        $this->resetValidation();
    }

    public function resetTipoVehiculoForm()
    {
        $this->tipoVehiculoId = null;
        $this->tipoVehiculoNombre = '';
        $this->tipoVehiculoCapacidadKg = '';
        $this->tipoVehiculoCapacidadM3 = '';
        $this->tipoVehiculoDescripcion = '';
        $this->tipoVehiculoActivo = true;
    }

    public function saveTipoVehiculo()
    {
        $this->validate([
            'tipoVehiculoNombre' => 'required|string|max:255',
            'tipoVehiculoCapacidadKg' => 'nullable|numeric|min:0',
            'tipoVehiculoCapacidadM3' => 'nullable|numeric|min:0',
        ], [
            'tipoVehiculoNombre.required' => 'El nombre es obligatorio',
            'tipoVehiculoCapacidadKg.numeric' => 'La capacidad debe ser numérica',
            'tipoVehiculoCapacidadM3.numeric' => 'La capacidad debe ser numérica',
        ]);

        if ($this->editTipoVehiculoMode) {
            $tipoVehiculo = TipoVehiculo::findOrFail($this->tipoVehiculoId);
            $tipoVehiculo->update([
                'nombre' => $this->tipoVehiculoNombre,
                'capacidad_max_kg' => $this->tipoVehiculoCapacidadKg,
                'capacidad_max_m3' => $this->tipoVehiculoCapacidadM3,
                'descripcion' => $this->tipoVehiculoDescripcion,
                'activo' => $this->tipoVehiculoActivo,
            ]);
            session()->flash('message', 'Tipo de vehículo actualizado exitosamente.');
        } else {
            TipoVehiculo::create([
                'nombre' => $this->tipoVehiculoNombre,
                'capacidad_max_kg' => $this->tipoVehiculoCapacidadKg,
                'capacidad_max_m3' => $this->tipoVehiculoCapacidadM3,
                'descripcion' => $this->tipoVehiculoDescripcion,
                'activo' => $this->tipoVehiculoActivo,
            ]);
            session()->flash('message', 'Tipo de vehículo creado exitosamente.');
        }

        $this->closeTipoVehiculoModal();
    }

    public function confirmDeleteTipoVehiculo($tipoVehiculoId)
    {
        $this->tipoVehiculoId = $tipoVehiculoId;
        $this->showTipoVehiculoDeleteModal = true;
    }

    public function deleteTipoVehiculo()
    {
        $tipoVehiculo = TipoVehiculo::findOrFail($this->tipoVehiculoId);
        $tipoVehiculo->delete();

        $this->showTipoVehiculoDeleteModal = false;
        $this->tipoVehiculoId = null;
        session()->flash('message', 'Tipo de vehículo eliminado exitosamente.');
    }

    public function cancelDeleteTipoVehiculo()
    {
        $this->showTipoVehiculoDeleteModal = false;
        $this->tipoVehiculoId = null;
    }

    public function toggleTipoVehiculoActivo($tipoVehiculoId)
    {
        $tipoVehiculo = TipoVehiculo::findOrFail($tipoVehiculoId);
        $tipoVehiculo->update(['activo' => !$tipoVehiculo->activo]);

        $status = $tipoVehiculo->activo ? 'activado' : 'desactivado';
        session()->flash('message', "Tipo de vehículo {$status} exitosamente.");
    }

    // ==================== TIPOS DE ENVÍO ====================

    public function openCreateTipoEnvioModal()
    {
        $this->resetTipoEnvioForm();
        $this->editTipoEnvioMode = false;
        $this->showTipoEnvioModal = true;
    }

    public function openEditTipoEnvioModal($tipoEnvioId)
    {
        $this->resetTipoEnvioForm();
        $tipoEnvio = TipoEnvio::findOrFail($tipoEnvioId);

        $this->tipoEnvioId = $tipoEnvio->id;
        $this->tipoEnvioNombre = $tipoEnvio->nombre;
        $this->tipoEnvioPrioridad = $tipoEnvio->prioridad;
        $this->tipoEnvioTarifaBase = $tipoEnvio->tarifa_base;
        $this->tipoEnvioTarifaPorKg = $tipoEnvio->tarifa_por_kg;
        $this->tipoEnvioTarifaPorM3 = $tipoEnvio->tarifa_por_m3;

        $this->editTipoEnvioMode = true;
        $this->showTipoEnvioModal = true;
    }

    public function closeTipoEnvioModal()
    {
        $this->showTipoEnvioModal = false;
        $this->resetTipoEnvioForm();
        $this->resetValidation();
    }

    public function resetTipoEnvioForm()
    {
        $this->tipoEnvioId = null;
        $this->tipoEnvioNombre = '';
        $this->tipoEnvioPrioridad = '';
        $this->tipoEnvioTarifaBase = '';
        $this->tipoEnvioTarifaPorKg = '';
        $this->tipoEnvioTarifaPorM3 = '';
    }

    public function saveTipoEnvio()
    {
        $this->validate([
            'tipoEnvioNombre' => 'required|string|max:255',
            'tipoEnvioPrioridad' => 'required|integer|min:1',
            'tipoEnvioTarifaBase' => 'required|numeric|min:0',
            'tipoEnvioTarifaPorKg' => 'required|numeric|min:0',
            'tipoEnvioTarifaPorM3' => 'required|numeric|min:0',
        ], [
            'tipoEnvioNombre.required' => 'El nombre es obligatorio',
            'tipoEnvioPrioridad.required' => 'La prioridad es obligatoria',
            'tipoEnvioTarifaBase.required' => 'La tarifa base es obligatoria',
            'tipoEnvioTarifaPorKg.required' => 'La tarifa por kg es obligatoria',
            'tipoEnvioTarifaPorM3.required' => 'La tarifa por m³ es obligatoria',
        ]);

        if ($this->editTipoEnvioMode) {
            $tipoEnvio = TipoEnvio::findOrFail($this->tipoEnvioId);
            $tipoEnvio->update([
                'nombre' => $this->tipoEnvioNombre,
                'prioridad' => $this->tipoEnvioPrioridad,
                'tarifa_base' => $this->tipoEnvioTarifaBase,
                'tarifa_por_kg' => $this->tipoEnvioTarifaPorKg,
                'tarifa_por_m3' => $this->tipoEnvioTarifaPorM3,
            ]);
            session()->flash('message', 'Tipo de envío actualizado exitosamente.');
        } else {
            TipoEnvio::create([
                'nombre' => $this->tipoEnvioNombre,
                'prioridad' => $this->tipoEnvioPrioridad,
                'tarifa_base' => $this->tipoEnvioTarifaBase,
                'tarifa_por_kg' => $this->tipoEnvioTarifaPorKg,
                'tarifa_por_m3' => $this->tipoEnvioTarifaPorM3,
            ]);
            session()->flash('message', 'Tipo de envío creado exitosamente.');
        }

        $this->closeTipoEnvioModal();
    }

    public function confirmDeleteTipoEnvio($tipoEnvioId)
    {
        $this->tipoEnvioId = $tipoEnvioId;
        $this->showTipoEnvioDeleteModal = true;
    }

    public function deleteTipoEnvio()
    {
        $tipoEnvio = TipoEnvio::findOrFail($this->tipoEnvioId);
        $tipoEnvio->delete();

        $this->showTipoEnvioDeleteModal = false;
        $this->tipoEnvioId = null;
        session()->flash('message', 'Tipo de envío eliminado exitosamente.');
    }

    public function cancelDeleteTipoEnvio()
    {
        $this->showTipoEnvioDeleteModal = false;
        $this->tipoEnvioId = null;
    }

    public function render()
    {
        $estados = EstadoEnvio::all();
        $tarifas = Tarifa::all();
        $tipoVehiculos = TipoVehiculo::all();
        $tiposEnvio = TipoEnvio::orderBy('prioridad')->get();

        return view('livewire.admin.settings', [
            'estados' => $estados,
            'tarifas' => $tarifas,
            'tipoVehiculos' => $tipoVehiculos,
            'tiposEnvio' => $tiposEnvio,
        ])->layout('layout.base-drawer');
    }
}
