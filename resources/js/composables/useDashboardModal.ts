import { ref } from 'vue';

const isDepositOpen = ref(false);
const initialDepositCategory = ref<string>('music');
const isSearchOpen = ref(false);

export function useDashboardModal() {
    function openDeposit(category = 'music') {
        initialDepositCategory.value = category;
        isDepositOpen.value = true;
    }

    function closeDeposit() {
        isDepositOpen.value = false;
    }

    function openSearch() {
        isSearchOpen.value = true;
    }

    function closeSearch() {
        isSearchOpen.value = false;
    }

    return {
        isDepositOpen,
        initialDepositCategory,
        isSearchOpen,
        openDeposit,
        closeDeposit,
        openSearch,
        closeSearch,
    };
}
