import { mount } from '@vue/test-utils'
import { createTestingPinia } from '@pinia/testing'
import { nextTick } from 'vue'
import { useProductStore } from '../../../stores/useProductStore'
import Colors from '../../partials/Colors.vue'

describe('Colors.vue', () => {
  it('renders color swatches and filters by id', async () => {
    const pinia = createTestingPinia({ createSpy: vi.fn })
    const wrapper = mount(Colors, { global: { plugins: [pinia] } })
    const store = useProductStore()

    store.colors = [
      { id: 10, name: 'red' },
      { id: 11, name: 'green' },
      { id: 12, name: 'blue' },
    ]
    await nextTick()

    const swatches = wrapper.findAll('[style]')
    expect(swatches).toHaveLength(3)

    await swatches[2].trigger('click')
    expect(store.filterProducts).toHaveBeenCalledWith('color', 12)
  })
})
