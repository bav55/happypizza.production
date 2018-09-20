<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <a href="{{ route('categories.index') }}" style="color: #000000;"><i class="fa fa-list-alt"></i> Все категории</a>
        </div>
        @if (count($categories) > 0)
            <div>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <td><strong>Название</strong></td><td></td><td></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->title }}</td>
                            <td>
                                <form action="{{ route('categories.edit', $category->id) }}" method="post">
                                    <input type="hidden" name="_method" value="get">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-primary btn-sm">Редактировать</button>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="post">
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
                {{ $categories->render() }}
            </div>
        </div>
    </div>
</div>