<div>
    <select
        class="border rounded p-2 text-black w-full mr-7 font-semibold focus:ring-2 focus:ring-inset  focus:ring-orange-500 sm:text-sm sm:leading-6"
        onchange="if (this.value) location = this.value;">

        <option value="{{ route(auth()->user()->roleName . 'remaining.balance.index') }}" disabled selected>All</option>
        <option value="{{ route(auth()->user()->roleName . 'remaining.balance.index', ['orderby' => 1]) }}"
            {{ request('orderby') == '1' ? 'selected' : '' }}>{{ __('Name') }}</option>
        <option value="{{ route(auth()->user()->roleName . 'remaining.balance.index', ['orderby' => 2]) }}"
            {{ request('orderby') == '2' ? 'selected' : '' }}>{{ __('Remaining Balance') }}</option>
        <option value="{{ route(auth()->user()->roleName . 'remaining.balance.index', ['orderby' => 3]) }}"
            {{ request('orderby') == '3' ? 'selected' : '' }}>{{ __('Plan Expired') }}</option>
        <option value="{{ route(auth()->user()->roleName . 'remaining.balance.index', ['orderby' => 4]) }}"
            {{ request('orderby') == '4' ? 'selected' : '' }}>{{ __('Follow Up date') }}</option>
    </select>
</div>
