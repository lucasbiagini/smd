<?php

namespace App\Repositories\Processo;

use App\Models\Processo;

interface IProcesso
{
    public function findById($id);
    public function paginateProcessos($sortBy, $sortDirection, $perPage, $status);
    public function store($name, $ref, $description, $setor_id);
    public function updateProcesso(Processo $processo, $name, $description, $ref);
    public function uploadImage(Processo $processo, $path, $filename, $type);
    public function deleteImage(Processo $processo);
    public function addOperador(Processo $processo);
    public function getOperadores(Processo $processo);
    public function updateProcessoProp(Processo $processo, $prop, $value);
    public function getFiles(Processo $processo);
    public function paginateDados(Processo $processo, $sortBy, $sortDirection, $perPage);
    public function paginateTitulares(Processo $processo, $sortBy, $sortDirection, $perPage);
    public function paginateCompartilhamentos(Processo $processo, $sortBy, $sortDirection, $perPage);
    public function paginateMedidas(Processo $processo, $sortBy, $sortDirection, $perPage);
    public function paginateTransferencias(Processo $processo, $sortBy, $sortDirection, $perPage);
    public function paginateContratos(Processo $processo, $sortBy, $sortDirection, $perPage);
    public function getAllDados(Processo $processo);
    public function analyse(Processo $processo);
    public function reject(Processo $processo);
    public function approve(Processo $processo);
    public function archive(Processo $processo);
    public function unarchive(Processo $processo);
}
