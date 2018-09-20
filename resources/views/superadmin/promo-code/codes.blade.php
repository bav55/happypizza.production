<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <a href="{{ route('p-cods.index') }}" style="color: #000000;"><i class="fa fa-barcode"></i> Все Промо коды</a>
        </div>
        @if (count($codes) > 0)
            <div>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <td><strong>Промо код</strong></td><td></td><td></td><td></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($codes as $code)
                        <tr>
                            <td>{{ $code->title }}</td>
                            <td><a href="{{ route('p-cods.show',$code->id) }}" type="button" class="btn btn-primary btn-sm">Информация</a></td>
                            <td>
                                <form action="{{ route('p-cods.edit', $code->id) }}" method="post">
                                    <input type="hidden" name="_method" value="get">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-primary btn-sm">Редактировать</button>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('p-cods.destroy', $code->id) }}" method="post">
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
                {{ $codes->render() }}
            </div>
        </div>
    </div>
</div>