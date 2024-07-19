@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span>{{ __('Lista de Tarefas') }}</span>
                    <div>
                        <a href="{{ url('/home') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                        <a href="{{ url('/tarefas/new') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-plus"></i> Nova Tarefa
                        </a>
                        <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#uploadModal">
                            <i class="fas fa-upload"></i> Upload Tarefas
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="list-group">
                        @foreach ($tarefas as $tarefa)
                            <a href="{{ url('/tarefas/' . $tarefa->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" style="background-color: {{ $loop->iteration % 2 == 0 ? '#f8f9fa' : '#e9ecef' }}">
                                <div class="d-flex w-100 justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-1">{{ $tarefa->title }}</h5>
                                    </div>
                                    <div class="me-3">
                                        <p class="mb-1">{{ $tarefa->description }}</p>
                                    </div>
                                    <div class="me-3">
                                        <small>Prazo: {{ $tarefa->days ?? 'Sem prazo' }} dias</small>
                                    </div>
                                    <div class="me-3" style="width: 20%;">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $tarefa->percentage }}%;" aria-valuenow="{{ $tarefa->percentage }}" aria-valuemin="0" aria-valuemax="100">{{ $tarefa->percentage }}%</div>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="badge bg-{{ $tarefa->is_completed ? 'success' : 'warning' }}">{{ $tarefa->is_completed ? 'Concluída' : 'Pendente' }}</span>
                                    </div>
                                    <div class="d-inline">
                                        <form action="{{ route('tarefas.destroy', $tarefa->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta tarefa?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Excluir
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    
                    @if($tarefas->isEmpty())
                        <div class="alert alert-info text-center mt-4">
                            Nenhuma tarefa encontrada.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload de Tarefas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="uploadForm" action="{{ url('/tarefasTpl/upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label">Selecione o arquivo</label>
                        <input type="file" class="form-control" id="file" name="file" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
                <hr>
                <button id="generateTemplate" class="btn btn-secondary">Gerar Template de Exemplo</button>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    var generateTemplateButton = document.getElementById('generateTemplate');
    if (generateTemplateButton) {
        generateTemplateButton.addEventListener('click', function() {
            alert('Gerar template de importação!');
            window.location.href = "{{ route('tarefasTpl.template') }}";
        });
    } else {
        console.error('Botão "generateTemplate" não encontrado.');
    }
});
</script>
