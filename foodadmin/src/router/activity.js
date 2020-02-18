import activity from '@/components/activity'


export default [{
        path: '/activity',
        name: 'activity',
        component: activity,
        meta: {
            requireAuth: true, //需要登录
        }
    },

]