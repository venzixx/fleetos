@props(['disabled' => false])

<input
    @disabled($disabled)
    {{ $attributes->merge([
        'class' => 'border-slate-200 bg-white text-slate-900 placeholder:text-slate-400 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm',
        'style' => 'display:block;width:100%;max-width:100%;min-width:0;box-sizing:border-box;min-height:56px;padding:0 16px;border:1px solid #cbd5e1;border-radius:18px;background:#ffffff;color:#0f172a;font-size:16px;line-height:1.2;font-family:Inter,sans-serif;outline:none;box-shadow:none;-webkit-appearance:none;appearance:none;'
    ]) }}
>
