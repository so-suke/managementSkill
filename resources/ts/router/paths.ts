export default [
  {
    path: '',
    name: 'Your Profile',
    view: 'YourProfile',
    meta: { requiresAuth: true }
  },
  {
    path: '/your-profile-update',
    name: 'Your Profile Update',
    view: 'YourProfileUpdate',
    meta: { requiresAuth: true }
  },
  {
    path: '/employee-list',
    name: 'Employee List',
    view: 'EmployeeList',
    meta: { requiresAuth: true }
  },
  {
    path: '/append-employee',
    name: 'Append Employee',
    view: 'EmployeeAppend',
    meta: { requiresAuth: true }
  },
  {
    path: '/skill-list',
    name: 'Skill List',
    view: 'SkillList',
    meta: { requiresAuth: true }
  },
  { path: '*', redirect: '/' }
]
