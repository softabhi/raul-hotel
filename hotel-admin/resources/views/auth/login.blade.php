@extends('layouts.auth')

@section('content')
<div class="w-full max-w-md bg-slate-900/60 backdrop-blur-xl border border-slate-800 rounded-3xl p-8 shadow-2xl relative overflow-hidden">
    
    <!-- Accent background decoration -->
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-amber-500/10 rounded-full blur-2xl"></div>
    <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-indigo-500/10 rounded-full blur-2xl"></div>

    <div class="text-center mb-8 relative">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-tr from-amber-500 to-amber-300 text-slate-950 font-bold text-2xl shadow-lg mb-4">
            <i data-lucide="hotel" class="w-8 h-8"></i>
        </div>
        <h1 class="font-playfair text-3xl font-bold text-white tracking-wide">THE LUXURY RESORT</h1>
        <p class="text-slate-400 text-sm mt-1">Admin Portal Control Panel</p>
    </div>

    <!-- Session Status / Errors -->
    @if(session('success'))
        <div class="mb-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
            <i data-lucide="check-circle" class="w-4 h-4 shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 bg-rose-500/10 border border-rose-500/20 text-rose-400 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
            <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 bg-rose-500/10 border border-rose-500/20 text-rose-400 px-4 py-3 rounded-xl text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5 relative">
        @csrf

        <div>
            <label for="email" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Email Address</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                    <i data-lucide="mail" class="w-5 h-5"></i>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       placeholder="admin@luxury.com" 
                       class="w-full bg-slate-950/60 border border-slate-800 rounded-xl py-3 pl-11 pr-4 text-white placeholder-slate-600 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-sm">
            </div>
        </div>

        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="password" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Password</label>
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                    <i data-lucide="lock" class="w-5 h-5"></i>
                </div>
                <input id="password" type="password" name="password" required
                       placeholder="••••••••••••"
                       class="w-full bg-slate-950/60 border border-slate-800 rounded-xl py-3 pl-11 pr-4 text-white placeholder-slate-600 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-sm">
            </div>
        </div>

        <button type="submit" 
                class="w-full bg-gradient-to-r from-amber-500 to-amber-400 hover:from-amber-600 hover:to-amber-500 text-slate-950 font-bold py-3 px-4 rounded-xl transition-all shadow-lg hover:shadow-amber-500/10 active:scale-[0.98] text-sm flex items-center justify-center gap-2">
            <span>Access Control Panel</span>
            <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </button>
    </form>

    <!-- Quick bypass / demo buttons -->
    <div class="mt-8 pt-6 border-t border-slate-800/80 text-center">
        <p class="text-xs text-slate-500 mb-3">Testing & Evaluation Credentials</p>
        <button onclick="autofillDemo()" 
                class="inline-flex items-center gap-2 bg-slate-800/40 hover:bg-slate-800/80 text-amber-500 text-xs py-2 px-4 rounded-lg border border-slate-800 transition-all cursor-pointer">
            <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
            <span>Autofill Admin Credentials</span>
        </button>
    </div>
</div>

<script>
    function autofillDemo() {
        document.getElementById('email').value = 'admin@luxury.com';
        document.getElementById('password').value = 'password123';
        
        // Show success visual feedback
        const btn = event.currentTarget;
        const origContent = btn.innerHTML;
        btn.innerHTML = '<i data-lucide="check" class="w-3.5 h-3.5"></i> Filled!';
        lucide.createIcons();
        setTimeout(() => {
            btn.innerHTML = origContent;
            lucide.createIcons();
        }, 1500);
    }
</script>
@endsection
