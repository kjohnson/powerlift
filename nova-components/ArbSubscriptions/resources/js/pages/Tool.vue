<template>
    <div>
        <Head title="Subscriptions" />

        <Heading class="mb-6">Subscriptions</Heading>

        <Card
            v-for="subscription in subscriptions"
            class="p-6 flex gap-4 items-baseline"
        >
            <Icon v-if="isActive(subscription)" class="text-green-500 self-center" type="check-circle" />
            <Icon v-else class="text-yellow-500 self-center" type="exclamation-circle" />

            <strong class="text-lg">{{ subscription.firstName }} {{ subscription.lastName }}</strong>
            <small>{{ subscription.id }}</small>
            <span>{{ subscription.name }}</span>
            <span>{{ formatCurrency(subscription.amount, subscription.currencyCode) }}</span>
        </Card>
    </div>
</template>

<script>
export default {
    data() {
        return {
            subscriptions: [],
        }
    },

    methods: {
        isActive(subscription) {
            return subscription.status === 'active'
        },
        formatCurrency(amount, currencyCode) {
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: currencyCode,
            }).format(amount)
        },
    },

    mounted() {
        Nova.request().get('/nova-vendor/arb-subscriptions').then(response => {
            this.subscriptions = response.data
        })
    },
}
</script>

<style>
/* Scoped Styles */
</style>
