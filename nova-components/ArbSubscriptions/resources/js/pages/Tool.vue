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
            <span>{{ subscription.amount }}</span>
            <span>{{ subscription.currencyCode }}</span>
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
