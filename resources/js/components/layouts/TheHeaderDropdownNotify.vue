<template>
    <CDropdown
        inNav
        class="c-header-nav-items"
        placement="bottom-end"
        add-menu-classes="pt-0"
    >
        <template #toggler>
            <CHeaderNavLink>
                <div class="c-avatar">
                    <CIcon name="cil-bell"/>
                    <!--                    <img-->
                    <!--                        :src=profileImageUrl-->
                    <!--                        class="c-avatar-img "-->
                    <!--                    />-->
                </div>
            </CHeaderNavLink>
        </template>
        <CDropdownHeader tag="div" class="text-center" color="light">
            <strong>Notifications</strong>
        </CDropdownHeader>
        <CDropdownItem>
            <router-link
                :to="'/notification/quotation'"
                class="notify-items"
            >
                <CIcon name="cil-bell"/>
                Quotations
                <CBadge color="info" class="mfs-auto">{{ quotationCount }}</CBadge>
            </router-link>
        </CDropdownItem>
        <CDropdownItem>
            <router-link
                :to="'/notification/purchase'"
                class="notify-items"
            >
                <CIcon name="cil-bell"/>
                Purchase Order
                <CBadge color="success" class="mfs-auto">{{ purchaseCount }}</CBadge>
            </router-link>
        </CDropdownItem>
    </CDropdown>
</template>

<script>
    import store from "../../store";
    import route from "../../router";
    import ApiServices from "../../services/ApiServices";
    import config from "../../config";

    export default {
        name: 'TheHeaderDropdownNotify',
        data() {
            return {
                totalUnreadCount: '',
                quotationCount: '',
                purchaseCount: '',
            }
        },
        created() {
            this.unreadCount();
        },
        methods: {
            async unreadCount() {
                let res = await ApiServices.getUnreadCount('All');
                if (res.success === true) {
                    this.totalUnreadCount = res.data;
                }
                let res1 = await ApiServices.getUnreadCount('Quotation');
                if (res1.success === true) {
                    this.quotationCount = res1.data;
                }
                let res2 = await ApiServices.getUnreadCount('PO');
                if (res2.success === true) {
                    this.purchaseCount = res2.data;
                }
            },
        }
    }
</script>

<style scoped>
    .c-icon {
        margin-right: 0.3rem;
    }

    .notify-items {
        display: flex !important;
        align-items: center !important;
        width: 100% !important;
        /*padding: 0.5rem 1.25rem !important;*/
        clear: both !important;
        font-weight: 400 !important;
        text-align: inherit !important;
        white-space: nowrap !important;
        background-color: transparent !important;
        border: 0 !important;
        color: #4f5d73 !important;
    }
</style>
