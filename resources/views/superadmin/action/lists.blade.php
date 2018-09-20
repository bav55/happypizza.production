<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <a href="{{ route('action.index') }}" style="color: #000000;"><i class="fa fa-list-alt"></i> Все акции</a>
        </div>
        @if (count($actions) > 0)
            <div>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <td><strong>Название</strong></td><td></td><td></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($actions as $action)
                        <tr>
                            <td>{{ $action->title }}</td>
                            <td>
                                <form action="{{ route('action.edit', $action->id) }}" method="post">
                                    <input type="hidden" name="_method" value="get">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-primary btn-sm">Редактировать</button>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('action.destroy', $action->id) }}" method="post">
                                    <input type="hidden" name="_method" value="delete">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        <div class="card-footer small text-muted">
            <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                {{ $actions->render() }}
            </div>
        </div>
    </div>
</div>