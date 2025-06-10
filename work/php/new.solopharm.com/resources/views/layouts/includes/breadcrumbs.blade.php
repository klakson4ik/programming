{!! $templates->renderBlock('common/breadcrumbs', [
    'data' => isset($breadcrumbsAdd) ? array_merge($breadcrumbs, $breadcrumbsAdd) : $breadcrumbs,
]) !!}