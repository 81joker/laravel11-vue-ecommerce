import { mount } from '@vue/test-utils'
import Home from '../Home.vue'

// Mock Pinia store used by Home.vue
const fetchAllProducts = vi.fn()

vi.mock('../../stores/useProductStore', () => ({
  __esModule: true,
  useProductStore: () => ({
    fetchAllProducts,
    isLoading: false,
    products: []
  })
}))

// Stub child components so we focus on Home.vue logic
const SpinnerStub = { name: 'Spinner', props: ['store'], template: '<div data-test="spinner"/>' }
const SidebarStub = { name: 'Sidebar', template: '<aside data-test="sidebar"/>' }
const ProductListStub = { name: 'ProductList', template: '<section data-test="product-list"/>' }

describe('Home.vue', () => {
  beforeEach(() => fetchAllProducts.mockClear())

  it('shows the page title', () => {
    const wrapper = mount(Home, { global: { stubs: { Spinner: SpinnerStub, Sidebar: SidebarStub, ProductList: ProductListStub } } })
    expect(wrapper.get('h1').text()).toBe('Welcome to Our Store')
  })

  it('renders Spinner, Sidebar and ProductList', () => {
    const wrapper = mount(Home, { global: { stubs: { Spinner: SpinnerStub, Sidebar: SidebarStub, ProductList: ProductListStub } } })
    expect(wrapper.get('[data-test="spinner"]').exists()).toBe(true)
    expect(wrapper.get('[data-test="sidebar"]').exists()).toBe(true)
    expect(wrapper.get('[data-test="product-list"]').exists()).toBe(true)
  })

  it('calls fetchAllProducts on mount', () => {
    mount(Home, { global: { stubs: { Spinner: SpinnerStub, Sidebar: SidebarStub, ProductList: ProductListStub } } })
    expect(fetchAllProducts).toHaveBeenCalledTimes(1)
  })

  it('passes store prop to Spinner', () => {
    const wrapper = mount(Home, { global: { stubs: { Spinner: SpinnerStub, Sidebar: SidebarStub, ProductList: ProductListStub } } })
    const spinner = wrapper.findComponent(SpinnerStub)
    expect(spinner.props('store')).toBeDefined()
  })
})
