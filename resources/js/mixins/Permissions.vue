<script>
export default {
    methods: {
        $can(...permissions) {
            for (const permission of permissions) {
                if (Permissions.indexOf(permission) !== -1) return true
            }
            return false
        },
    },
};
</script>
