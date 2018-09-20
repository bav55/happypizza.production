<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <a href="{{ route('faqs.index') }}" style="color: #000000;"><i class="fa fa-list-alt"></i> Все ЧаВо</a>
        </div>
        @if (count($faqs) > 0)
            <div>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <td><strong>Название</strong></td><td><strong>Активный</strong></td><td></td><td></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($faqs as $faq)
                        <tr>
                            <td>{{ $faq->question }}</td>
                            <td>{!! $faq->is_active == 1 ? '<i class="fa fa-check-square-o"></i>' : '<i class="fa fa-close"></i>' !!}</td>
                            <td>
                                <form action="{{ route('faqs.edit', $faq->id) }}" method="post">
                                    <input type="hidden" name="_method" value="get">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-primary btn-sm">Редактировать</button>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('faqs.destroy', $faq->id) }}" method="post">
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
                {{ $faqs->render() }}
            </div>
        </div>
    </div>
</div>