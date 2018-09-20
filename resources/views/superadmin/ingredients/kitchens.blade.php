<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <a href="{{ route($url.'.index') }}" style="color: #000000;"><i class="fa fa-list-alt"></i> Все {{ $title }}</a>
        </div>
        @if (count($values) > 0)
            <div>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <td><strong>Название</strong></td><td></td><td></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($values as $value)
                        <tr>
                            <td>{{ $value->title }}</td>
                            <td>
                                <form action="{{ route($url.'.edit', $value->id) }}" method="post">
                                    <input type="hidden" name="_method" value="get">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-primary btn-sm">Редактировать</button>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route($url.'.destroy', $value->id) }}" method="post">
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
                {{ $values->render() }}
            </div>
        </div>
    </div>
</div>